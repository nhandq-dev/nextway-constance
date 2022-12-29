<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Repository\UserRepository;
use App\Utils\SocialUtil;
use App\Utils\UserUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Defines the properties of the User entity to represent the application users.
 * See https://symfony.com/doc/current/doctrine.html#creating-an-entity-class.
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See https://symfony.com/doc/current/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'tbl_user')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['phone'], message: 'There is already an account with this phone number')]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: Types::INTEGER)]
  private ?int $id = null;

  #[ORM\Column(type: Types::STRING, name: 'first_name', nullable: true)]
  #[Assert\Length(max: 128)]
  private ?string $firstName = null;

  #[ORM\Column(type: Types::STRING, name: 'last_name', nullable: true)]
  #[Assert\Length(max: 128)]
  private ?string $lastName = null;

  #[ORM\Column(type: Types::STRING, unique: true, nullable: true)]
  #[Assert\Email]
  private ?string $email = null;

  #[ORM\Column(type: Types::STRING, unique: true, nullable: true)]
  #[Assert\Length(max: 16)]
  #[Assert\Regex('/^\+[1-9][0-9]{1,14}$/')]
  private ?string $phone = null;

  #[ORM\Column(type: Types::STRING, nullable: true)]
  private ?string $password = null;

  /**
   * @var string[]
   */
  #[ORM\Column(type: Types::JSON)]
  private array $roles = [];

  #[ORM\OneToMany(mappedBy: 'person', targetEntity: Activity::class)]
  private Collection $activities;

  private $team = null;
  private $community = null;
  private ?Collection $socialCollection = null;

  #[ORM\OneToOne(mappedBy: 'responsedUser', cascade: ['persist', 'remove'])]
  private ?QuestionnaireResponse $quuestionnaireResponse = null;

  #[ORM\OneToMany(mappedBy: 'person', targetEntity: UserDailyEmotion::class)]
  private ?Collection $userDailyEmotion;

  #[ORM\Column(type: Types::BINARY, nullable: true)]
  private ?string $avatar = null;

  #[ORM\Column(type: Types::SMALLINT, nullable: false)]
  private int $status = UserUtil::ACTIVE;

  #[ORM\OneToMany(mappedBy: 'person', targetEntity: UserSocial::class, cascade: ['persist', 'remove'])]
  private Collection $userSocials;

  public function __construct()
  {
    parent::__construct();
    $this->activities = new ArrayCollection();
    $this->userDailyEmotion = new ArrayCollection();
    $this->roles = [UserUtil::ROLE_USER];
    $this->userSocials = new ArrayCollection();
    $this->socialCollection = new ArrayCollection();
  }

  public function __toString(): string
  {
    return $this->getUserIdentifier();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setFirstName(string $firstName): void
  {
    $this->firstName = $firstName;
  }

  public function getFirstName(): ?string
  {
    return $this->firstName;
  }

  public function getUserIdentifier(): string
  {
    return (string) $this->phone;
  }

  public function setLastName(string $lastName): void
  {
    $this->lastName = $lastName;
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function setEmail(string $email): void
  {
    $this->email = $email;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): void
  {
    $this->password = $password;
  }

  public function getPhone(): ?string
  {
    return $this->phone;
  }

  public function setPhone(string $phone): void
  {
    $this->phone = $phone;
  }

  public function getAvatar(): ?string
  {
    return $this->avatar;
  }

  public function setAvatar(string $avatar): void
  {
    $this->avatar = $avatar;
  }

  /**
   * Returns the roles or permissions granted to the user for security.
   */
  public function getRoles(): array
  {
    $roles = $this->roles;

    // guarantees that a user always has at least one role for security
    if (empty($roles)) {
      $roles[] = UserUtil::ROLE_USER;
    }

    return array_unique($roles);
  }

  /**
   * @param string[] $roles
   */
  public function setRoles(array $roles): void
  {
    $this->roles = $roles;
  }

  /**
   * Returns the salt that was originally used to encode the password.
   *
   * {@inheritdoc}
   */
  public function getSalt(): ?string
  {
    // We're using bcrypt in security.yaml to encode the password, so
    // the salt value is built-in and you don't have to generate one
    // See https://en.wikipedia.org/wiki/Bcrypt

    return null;
  }

  /**
   * Removes sensitive data from the user.
   *
   * {@inheritdoc}
   */
  public function eraseCredentials(): void
  {
    // if you had a plainPassword property, you'd nullify it here
    // $this->plainPassword = null;
  }

  /**
   * @return array{int|null, string|null, string|null}
   */
  public function __serialize(): array
  {
    // add $this->salt too if you don't use Bcrypt or Argon2i
    return [$this->id, $this->firstName, $this->lastName, $this->password];
  }

  /**
   * @param array{int|null, string, string} $data
   */
  public function __unserialize(array $data): void
  {
    // add $this->salt too if you don't use Bcrypt or Argon2i
    [$this->id, $this->firstName, $this->lastName, $this->password] = $data;
  }

  /**
   * @return Collection<int, Activity>
   */
  public function getActivities(): Collection
  {
    return $this->activities;
  }

  public function addActivity(Activity $activity): self
  {
    if (!$this->activities->contains($activity)) {
      $this->activities->add($activity);
      $activity->setPerson($this);
    }

    return $this;
  }

  public function removeActivity(Activity $activity): self
  {
    if ($this->activities->removeElement($activity)) {
      // set the owning side to null (unless already changed)
      if ($activity->getPerson() === $this) {
        $activity->setPerson(null);
      }
    }

    return $this;
  }

  public function getStatus(): ?int
  {
    return $this->status;
  }

  public function setStatus(?int $status): self
  {
    $this->status = $status;

    return $this;
  }

  public function getQuuestionnaire(): ?QuestionnaireResponse
  {
    return $this->quuestionnaireResponse;
  }

  public function setQuuestionnaire(?QuestionnaireResponse $quuestionnaireResponse): self
  {
    // unset the owning side of the relation if necessary
    if ($quuestionnaireResponse === null && $this->quuestionnaireResponse !== null) {
      $this->quuestionnaireResponse->setResponsedUser(null);
    }

    // set the owning side of the relation if necessary
    if ($quuestionnaireResponse !== null && $quuestionnaireResponse->getResponsedUser() !== $this) {
      $quuestionnaireResponse->setResponsedUser($this);
    }

    $this->quuestionnaireResponse = $quuestionnaireResponse;

    return $this;
  }

  /**
   * @return Collection<int, UserDailyEmotion>
   */
  public function getUserDailyEmotiones(): Collection
  {
    return $this->userDailyEmotion;
  }

  public function addUserDailyEmotion(UserDailyEmotion $userWellness): self
  {
    if (!$this->userDailyEmotion->contains($userWellness)) {
      $this->userDailyEmotion->add($userWellness);
      $userWellness->setPerson($this);
    }

    return $this;
  }

  public function removeUserDailyEmotion(UserDailyEmotion $userWellness): self
  {
    if ($this->userDailyEmotion->removeElement($userWellness)) {
      // set the owning side to null (unless already changed)
      if ($userWellness->getPerson() === $this) {
        $userWellness->setPerson(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, UserSocial>
   */
  public function getUserSocials(): Collection
  {
    return $this->userSocials;
  }

  public function addUserSocial(UserSocial $userSocial): self
  {
    if (!$this->userSocials->contains($userSocial)) {
      $this->userSocials->add($userSocial);
      $userSocial->setPerson($this);
    }

    return $this;
  }

  public function removeUserSocial(UserSocial $userSocial): self
  {
    if ($this->userSocials->removeElement($userSocial)) {
      // set the owning side to null (unless already changed)
      if ($userSocial->getPerson() === $this) {
        $userSocial->setPerson(null);
      }
    }

    return $this;
  }

  public function emptyUserSocial(): self
  {
    foreach ($this->userSocials as $userSocial) {
      if ($this->userSocials->removeElement($userSocial)) {
        // set the owning side to null (unless already changed)
        if ($userSocial->getPerson() === $this) {
          $userSocial->setPerson(null);
        }
      }
    }

    return $this;
  }

  public function getCommunity(): ?string
  {
    if ($this->community) {
      return $this->community;
    }
    $community = $this->userSocials->filter(
      function (UserSocial $entry) {
        return $entry->getSocial()->getType() === SocialUtil::TYPE_COMMUNITY;
      }
    )->first();

    return $community ? $community->getSocial()->getId() : null;
  }

  public function setCommunity(?int $communityId): self
  {
    $this->community = $communityId;
    return $this;
  }

  public function getTeam(): ?string
  {
    if ($this->team) {
      return $this->team;
    }
    $team = $this->userSocials->filter(
      function (UserSocial $entry) {
        return $entry->getSocial()->getType() === SocialUtil::TYPE_TEAM;
      }
    )->first();

    return $team ? $team->getSocial()->getId() : null;
  }

  public function setTeam(?int $teamId): self
  {
    $this->team = $teamId;
    return $this;
  }
}
