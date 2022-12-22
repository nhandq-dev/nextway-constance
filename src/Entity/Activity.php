<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[ORM\Table(name: 'tbl_activity')]
class Activity extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column(name: 'activity_date', type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $activityDate = null;

    #[ORM\Column(name: 'is_repeat', type: Types::BOOLEAN, nullable: true)]
    #[Assert\NotBlank]
    private ?bool $isRepeat = false;

    #[ORM\Column(name: 'repeat_amount', type: Types::INTEGER, nullable: true)]
    #[Assert\NotBlank]
    private ?int $repeatAmount = null;

    #[ORM\Column(name: 'repeat_unit', type: Types::STRING, nullable: true)]
    #[Assert\NotBlank]
    private ?string $repeatUnit = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(name: "owner_id", referencedColumnName: "id")]
    private ?User $owner = null;

    #[ORM\OneToOne(mappedBy: 'onTask', cascade: ['persist', 'remove'])]
    private ?QuestionnaireResponse $response = null;

    #[ORM\Column(name: 'status', type: Types::INTEGER)]
    private ?int $status = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function __toString(): string
    {
        return '#' . $this->id . ' ' . $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getActivityDate(): ?\DateTimeInterface
    {
        return $this->activityDate;
    }

    public function setActivityDate(\DateTimeInterface $activityDate): self
    {
        $this->activityDate = $activityDate;

        return $this;
    }

    public function getIsRepeat(): ?bool
    {
        return $this->isRepeat;
    }

    public function setIsRepeat(bool $isRepeat): self
    {
        $this->isRepeat = $isRepeat;

        return $this;
    }

    public function getRepeatAmount(): ?int
    {
        return $this->repeatAmount;
    }

    public function setRepeatAmount(int $repeatAmount): self
    {
        $this->repeatAmount = $repeatAmount;

        return $this;
    }

    public function getRepeatUnit(): ?string
    {
        return $this->repeatUnit;
    }

    public function setRepeatUnit(string $repeatUnit): self
    {
        $this->repeatUnit = $repeatUnit;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getResponse(): ?QuestionnaireResponse
    {
        return $this->response;
    }

    public function setResponse(?QuestionnaireResponse $response): self
    {
        // unset the owning side of the relation if necessary
        if ($response === null && $this->response !== null) {
            $this->response->setOnTask(null);
        }

        // set the owning side of the relation if necessary
        if ($response !== null && $response->getOnTask() !== $this) {
            $response->setOnTask($this);
        }

        $this->response = $response;

        return $this;
    }
}
