<?php

namespace App\Entity;

use App\Repository\UserWellnessRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserWellnessRepository::class)]
#[ORM\Table(name: 'tbl_user_daily_emotion')]
class UserDailyEmotion extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'question_object', type: Types::JSON)]
    private ?int $questionObject = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $rate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reason = null;

    #[ORM\ManyToOne(inversedBy: 'userDailyEmotion')]
    private ?User $person = null;

    #[ORM\ManyToOne(inversedBy: 'userDailyEmotion')]
    private ?Question $question = null;

    public function __construct()
    {
        parent::__construct();
    }

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

    public function getQuestionObject(): ?object
    {
        return $this->questionObject;
    }

    public function setQuestionObject(?object $question): self
    {
        return $this->questionObject = $question;

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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
