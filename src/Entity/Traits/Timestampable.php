<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
  #[ORM\Column(type: 'datetime_immutable')]
  private $createdAt;

  #[ORM\Column(type: 'datetime')]
  private $updatedAt;

  #[ORM\PrePersist]
  public function setCreatedAtValue(): void
  {
    $this->createdAt = new \DateTimeImmutable();
    $this->updatedAt = new \DateTime();
  }

  #[ORM\PreUpdate]
  public function setUpdatedAtValue(): void
  {
    $this->updatedAt = new \DateTime();
  }
}
