<?php

namespace App\Controller\Admin;

// use App\Entity\AccessToken;
use App\Entity\Social;
use App\Entity\User;
use App\Entity\UserSocial;
use App\Utils\SocialUtil;
use App\Utils\UserUtil;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    const WEP_APP_IDENTIFIER = '1112feaab25125b333cf3df3964a1a1c';
    private $entityManager;
    private $socialMapById;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->socialMapById = new ArrayCollection();
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')
            ->setSearchFields(['firstName', 'lastName', 'email'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('firstName'))
            ->add(TextFilter::new('lastName'));
    }

    public function configureFields(string $pageName): iterable
    {
        $listSocial = $this->entityManager->getRepository(Social::class)->getSocialByType();

        $communityAsOptions = [];
        $teamAsOptions = [];
        foreach ($listSocial as $social) {
            $this->socialMapById->set($social->getId(), $social);

            if ($social->getType() === SocialUtil::TYPE_TEAM) {
                $teamAsOptions[$social->getIdentifier()] = $social->getId();
            } else if ($social->getType() === SocialUtil::TYPE_COMMUNITY) {
                $communityAsOptions[$social->getIdentifier()] = $social->getId();
            }
        }

        yield ChoiceField::new('team')
            ->setChoices(
                fn () => $teamAsOptions
            )
            ->autocomplete()
            ->setRequired(true);
        yield ChoiceField::new('community')
            ->setChoices(
                fn () => $communityAsOptions
            )
            ->autocomplete()
            ->setRequired(true);

        yield TextField::new('firstName')->setRequired(true);
        yield TextField::new('lastName')->setRequired(true);
        yield EmailField::new('email')->setRequired(false);
        yield TextField::new('phone')->setRequired(true);

        yield DateTimeField::new('createdAt')->setFormTypeOptions([
            'html5' => true,
            'years' => range(date('Y'), date('Y') + 5),
            'widget' => 'single_text',
        ])->setEmptyData(new DateTime('now'))->onlyOnIndex();
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $queryBuilder->andWhere("JSON_GET_TEXT(entity.roles, 0) = :role")->setParameter('role', UserUtil::ROLE_USER);

        return $queryBuilder;
    }

    public function configureActions(Actions $actions): Actions
    {
        $getLoginLink = Action::new('getLoginLink', 'Login link', 'fa fa-link')
            ->linkToCrudAction('getLoginLink');

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $getLoginLink);
    }

    public function getLoginLink(AdminContext $context)
    {
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->emptyUserSocial();
        $teamEntity = $this->socialMapById->get($entityInstance->getTeam());
        $communityEntity = $this->socialMapById->get($entityInstance->getCommunity());

        $userTeamSocial = new UserSocial();
        $userTeamSocial->setPerson($entityInstance);
        $userTeamSocial->setSocial($teamEntity);

        $userCommunitySocial = new UserSocial();
        $userCommunitySocial->setPerson($entityInstance);
        $userCommunitySocial->setSocial($communityEntity);

        $entityInstance->addUserSocial($userTeamSocial);
        $entityInstance->addUserSocial($userCommunitySocial);
        // dump('$entityInstance = ', $entityInstance) . die;
        // $entityInstance->setType(SocialUtil::TYPE_TEAM);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->emptyUserSocial();
        $teamEntity = $this->socialMapById->get($entityInstance->getTeam());
        $communityEntity = $this->socialMapById->get($entityInstance->getCommunity());

        $userTeamSocial = new UserSocial();
        $userTeamSocial->setPerson($entityInstance);
        $userTeamSocial->setSocial($teamEntity);

        $userCommunitySocial = new UserSocial();
        $userCommunitySocial->setPerson($entityInstance);
        $userCommunitySocial->setSocial($communityEntity);

        $entityInstance->addUserSocial($userTeamSocial);
        $entityInstance->addUserSocial($userCommunitySocial);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
