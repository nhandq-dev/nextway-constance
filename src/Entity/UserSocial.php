<?php

namespace App\Entity;

use App\Repository\UserSocialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSocialRepository::class)]
#[ORM\Table(name: 'tbl_user_social')]
class UserSocial extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userSocials')]
    private ?User $person = null;

    #[ORM\ManyToOne(inversedBy: 'userSocials', cascade: ['persist', 'remove'])]
    private ?Social $social = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?User
    {
        return $this->person;
    }

    public function setPerson(?User $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getSocial(): ?Social
    {
        return $this->social;
    }

    public function setSocial(?Social $social): self
    {
        $this->social = $social;

        return $this;
    }
}
