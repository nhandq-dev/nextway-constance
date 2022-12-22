<?php

namespace App\Entity;

use App\Repository\QuestionnaireResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: QuestionnaireResponseRepository::class)]
#[ORM\Table(name: 'tbl_questionnaire_response')]
#[UniqueEntity(fields: ['responsedUser', 'onTask', 'questionnaire'], message: 'There is already response taked for this task')]
class QuestionnaireResponse extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isFinished = null;

    #[ORM\ManyToOne(inversedBy: 'responses')]
    #[ORM\JoinColumn(name: "questionnaire_id", referencedColumnName: "id")]
    private ?Questionnaire $questionnaire = null;

    #[ORM\OneToOne(inversedBy: 'quuestionnaire', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $responsedUser = null;

    #[ORM\OneToOne(inversedBy: 'response', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "activity_id", referencedColumnName: "id")]
    private ?Activity $onTask = null;

    #[ORM\OneToMany(mappedBy: 'questionnaireResponse', targetEntity: ResponseDetail::class)]
    private Collection $responseDetails;

    public function __construct()
    {
        parent::__construct();
        $this->responseDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

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

    public function getResponsedUser(): ?User
    {
        return $this->responsedUser;
    }

    public function setResponsedUser(?User $responsedUser): self
    {
        $this->responsedUser = $responsedUser;

        return $this;
    }

    public function getOnTask(): ?Activity
    {
        return $this->onTask;
    }

    public function setOnTask(?Activity $onTask): self
    {
        $this->onTask = $onTask;

        return $this;
    }

    /**
     * @return Collection<int, ResponseDetail>
     */
    public function getResponseDetails(): Collection
    {
        return $this->responseDetails;
    }

    public function addResponseDetail(ResponseDetail $responseDetail): self
    {
        if (!$this->responseDetails->contains($responseDetail)) {
            $this->responseDetails->add($responseDetail);
            $responseDetail->setQuestionnaireResponse($this);
        }

        return $this;
    }

    public function removeResponseDetail(ResponseDetail $responseDetail): self
    {
        if ($this->responseDetails->removeElement($responseDetail)) {
            // set the owning side to null (unless already changed)
            if ($responseDetail->getQuestionnaireResponse() === $this) {
                $responseDetail->setQuestionnaireResponse(null);
            }
        }

        return $this;
    }
}
