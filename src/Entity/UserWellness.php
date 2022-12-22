<?php

namespace App\Entity;

use App\Repository\UserWellnessRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserWellnessRepository::class)]
class UserWellness
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $rate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reason = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $context_type = null;

    #[ORM\Column(nullable: true)]
    private ?int $context_id = null;

    #[ORM\ManyToOne(inversedBy: 'userWellnesses')]
    private ?User $person = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getContextType(): ?string
    {
        return $this->context_type;
    }

    public function setContextType(?string $context_type): self
    {
        $this->context_type = $context_type;

        return $this;
    }

    public function getContextId(): ?int
    {
        return $this->context_id;
    }

    public function setContextId(?int $context_id): self
    {
        $this->context_id = $context_id;

        return $this;
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
}
