<?php

namespace App\Repository;

use App\Entity\Social;
use App\Utils\SocialUtil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Social>
 *
 * @method Social|null find($id, $lockMode = null, $lockVersion = null)
 * @method Social|null findOneBy(array $criteria, array $orderBy = null)
 * @method Social[]    findAll()
 * @method Social[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocialRepository extends ServiceEntityRepository
{
    private $serializer;

    public function __construct(ManagerRegistry $registry, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        parent::__construct($registry, Social::class);
    }

    public function save(Social $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Social $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSocialByType(?int $type = null)
    {
        $socialByType = $this->createQueryBuilder('social')
            ->andWhere('social.isActive = :active')
            ->setParameter('active', SocialUtil::ACTIVE);

        if (in_array($type, array_keys(SocialUtil::SOCIAL_TYPE_MAPPING))) {
            $socialByType->andWhere('social.type = :type')->setParameter('type', $type);
        }

        return $socialByType
            ->orderBy('social.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getManyAndCount(?int $type = SocialUtil::TYPE_TEAM, ?int $page = 1, ?int $pageSize = 20, ?string $keyword)
    {
        $queryBuilder = $this
            ->createQueryBuilder('social')
            ->select("COUNT_OVER(social.id) AS total, social.id, social.name, social.description, social.createdAt")
            ->andWhere('social.isActive = :active')
            ->setParameter('active', SocialUtil::ACTIVE);

        switch ($type) {
            case SocialUtil::TYPE_TEAM:
                $queryBuilder
                    ->andWhere('social.type = :type')
                    ->setParameter('type', SocialUtil::TYPE_TEAM);
                break;
            case SocialUtil::TYPE_COMMUNITY:
                $queryBuilder
                    ->andWhere('social.type = :type')
                    ->setParameter('type', SocialUtil::TYPE_COMMUNITY);
                break;

            default:
                $queryBuilder
                    ->andWhere('social.type = :type')
                    ->setParameter('type', SocialUtil::TYPE_TEAM);
                break;
        }

        if ($keyword) {
            $queryBuilder
                ->andWhere('social.name ILIKE :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        return $queryBuilder
            ->setMaxResults($pageSize)
            ->setFirstResult($page)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Social[] Returns an array of Social objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Social
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
