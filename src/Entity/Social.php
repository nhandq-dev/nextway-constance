<?php

namespace App\Entity;

use App\Repository\SocialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocialRepository::class)]
#[ORM\Table(name: 'tbl_social')]
#[UniqueEntity(fields: ['type', 'name'], message: 'There is already an social with this name')]
class Social extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $isActive = null;

    #[ORM\Column(name: 'is_default', type: Types::BOOLEAN)]
    private ?bool $isDefault = false;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\OneToMany(mappedBy: 'social', targetEntity: UserSocial::class)]
    private Collection $userSocials;

    private $total;

    public function __construct()
    {
        parent::__construct();
        $this->userSocials = new ArrayCollection();
    }

    /**
     * @return array{int|null, string|null, string|null}
     */
    public function __serialize(): array
    {
        return [$this->id, $this->name, $this->description, $this->isActive, $this->isDefault, $this->type];
    }

    /**
     * @param array{int|null, string, string} $data
     */
    public function __unserialize(array $data): void
    {
        [$this->id, $this->name, $this->description, $this->isActive, $this->isDefault, $this->type] = $data;
    }

    public function getIdentifier(): ?string
    {
        return '#' . $this->id . ' ' . $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isIsDefault(): ?bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, UserSocial>
     */
    public function getUserSocial(): Collection
    {
        return $this->userSocials;
    }

    public function addUserSocial(UserSocial $userSocial): self
    {
        if (!$this->userSocials->contains($userSocial)) {
            $this->userSocials->add($userSocial);
            $userSocial->setSocial($this);
        }

        return $this;
    }

    public function removeUserSocial(UserSocial $userSocial): self
    {
        if ($this->userSocials->removeElement($userSocial)) {
            // set the owning side to null (unless already changed)
            if ($userSocial->getSocial() === $this) {
                $userSocial->setSocial(null);
            }
        }

        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total): self
    {
        $this->total = $total;

        return $this;
    }
}
