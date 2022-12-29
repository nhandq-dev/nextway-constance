<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'tbl_question')]
class Question extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column(name: 'is_primary', type: Types::BOOLEAN)]
    private ?bool $isPrimary = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionOption::class)]
    private Collection $questionOptions;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionnaireQuestion::class)]
    private Collection $questionnaire;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: UserDailyEmotion::class)]
    private Collection $userDailyEmotion;

    public function __construct()
    {
        parent::__construct();
        $this->questionOptions = new ArrayCollection();
        $this->questionnaire = new ArrayCollection();
        $this->userDailyEmotion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getIsPrimary(): int
    {
        return $this->isPrimary;
    }

    public function setIsPrimary(bool $isPrimary): self
    {
        $this->isPrimary = $isPrimary;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Collection<int, QuestionOption>
     */
    public function getQuestionOptions(): Collection
    {
        return $this->questionOptions;
    }

    public function addQuestionOption(QuestionOption $questionOption): self
    {
        if (!$this->questionOptions->contains($questionOption)) {
            $this->questionOptions->add($questionOption);
            $questionOption->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionOption(QuestionOption $questionOption): self
    {
        if ($this->questionOptions->removeElement($questionOption)) {
            // set the owning side to null (unless already changed)
            if ($questionOption->getQuestion() === $this) {
                $questionOption->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuestionnaireQuestion>
     */
    public function getQuestionnaire(): Collection
    {
        return $this->questionnaire;
    }

    public function addQuestionnaire(QuestionnaireQuestion $questionnaire): self
    {
        if (!$this->questionnaire->contains($questionnaire)) {
            $this->questionnaire->add($questionnaire);
            $questionnaire->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionnaire(QuestionnaireQuestion $questionnaire): self
    {
        if ($this->questionnaire->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getQuestion() === $this) {
                $questionnaire->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, userDailyEmotion>
     */
    public function getUserDailyEmotion(): Collection
    {
        return $this->userDailyEmotion;
    }

    public function addUserDailyEmotion(UserDailyEmotion $userDailyEmotion): self
    {
        if (!$this->userDailyEmotion->contains($userDailyEmotion)) {
            $this->userDailyEmotion->add($userDailyEmotion);
            $userDailyEmotion->setQuestion($this);
        }

        return $this;
    }

    public function removeUserDailyEmotion(UserDailyEmotion $userDailyEmotion): self
    {
        if ($this->userDailyEmotion->removeElement($userDailyEmotion)) {
            // set the owning side to null (unless already changed)
            if ($userDailyEmotion->getQuestion() === $this) {
                $userDailyEmotion->setQuestion(null);
            }
        }

        return $this;
    }
}
