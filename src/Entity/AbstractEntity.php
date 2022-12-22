<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass()]
#[ORM\HasLifecycleCallbacks]
abstract class AbstractEntity
{
  #[ORM\Column(name: "created_at", type: Types::DATETIME_MUTABLE, nullable: true)]
  private $createdAt;

  #[ORM\Column(name: "updated_at", type: "datetime", nullable: true)]
  private $updatedAt;

  public function __construct()
  {
    $currentDate = new \DateTime();
    $this->createdAt = $currentDate;
    $this->updatedAt = $currentDate;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }


  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
    return $this;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt($updatedAt)
  {
    $this->updatedAt = $updatedAt;
    return $this;
  }

  #[ORM\PreUpdate]
  public function setUpdatedAtValue(PreUpdateEventArgs $args)
  {
    $object = $args->getObject();
    $object->setUpdatedAt(new \DateTime());
  }
}
