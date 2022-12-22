<?php

namespace App\Entity;

use App\Repository\ResponseDetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseDetailRepository::class)]
class ResponseDetail extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'responseDetails')]
    #[ORM\JoinColumn(name: "questionnaire_response_id", referencedColumnName: "id")]
    private ?QuestionnaireResponse $questionnaireResponse = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $question = null;

    /**
     * @var string[]
     */
    #[ORM\Column(type: Types::JSON)]
    private ?array $options = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionnaireResponse(): ?QuestionnaireResponse
    {
        return $this->questionnaireResponse;
    }

    public function setQuestionnaireResponse(?QuestionnaireResponse $questionnaireResponse): self
    {
        $this->questionnaireResponse = $questionnaireResponse;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
