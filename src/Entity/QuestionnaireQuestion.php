<?php

namespace App\Entity;

use App\Repository\QuestionnaireQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionnaireQuestionRepository::class)]
#[ORM\Table(name: 'tbl_questionnaire_question')]
class QuestionnaireQuestion extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\ManyToOne(inversedBy: 'questionDetail')]
    #[ORM\JoinColumn(name: "questionnaire_id", referencedColumnName: "id")]
    private ?Questionnaire $questionnaire = null;

    #[ORM\ManyToOne(inversedBy: 'questionnaire')]
    #[ORM\JoinColumn(name: "question_id", referencedColumnName: "id")]
    private ?Question $question = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

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
