<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
#[ORM\Table(name: 'tbl_questionnaire')]
class Questionnaire extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 125)]
    private ?string $name = null;

    #[ORM\Column(name: 'is_publish', type: Types::BOOLEAN)]
    private ?bool $isPublish = null;

    #[ORM\Column(name: 'publish_date', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $publishDate = null;

    #[ORM\Column(name: 'flated_questionnaire', type: Types::JSON, nullable: true)]
    private ?array $flatedQuestionnaire = [];

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: QuestionnaireResponse::class)]
    private Collection $responses;

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: QuestionnaireQuestion::class)]
    private Collection $questionDetail;

    public function __construct()
    {
        parent::__construct();
        $this->responses = new ArrayCollection();
        $this->questionDetail = new ArrayCollection();
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

    public function isIsPublish(): ?bool
    {
        return $this->isPublish;
    }

    public function setIsPublish(bool $isPublish): self
    {
        $this->isPublish = $isPublish;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(?\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getFlatedQuestionnaire(): ?array
    {
        return $this->flatedQuestionnaire;
    }

    public function setFlatedQuestionnaire(?array $flatedQuestionnaire): self
    {
        $this->flatedQuestionnaire = $flatedQuestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, QuestionnaireResponse>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponseDetail(QuestionnaireResponse $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeResponseDetail(QuestionnaireResponse $response): self
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getQuestionnaire() === $this) {
                $response->setQuestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuestionnaireQuestion>
     */
    public function getQuestionDetail(): Collection
    {
        return $this->questionDetail;
    }

    public function addQuestionDetail(QuestionnaireQuestion $questionDetail): self
    {
        if (!$this->questionDetail->contains($questionDetail)) {
            $this->questionDetail->add($questionDetail);
            $questionDetail->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeQuestionDetail(QuestionnaireQuestion $questionDetail): self
    {
        if ($this->questionDetail->removeElement($questionDetail)) {
            // set the owning side to null (unless already changed)
            if ($questionDetail->getQuestionnaire() === $this) {
                $questionDetail->setQuestionnaire(null);
            }
        }

        return $this;
    }
}
