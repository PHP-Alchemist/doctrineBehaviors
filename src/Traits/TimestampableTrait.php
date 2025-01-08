<?php

namespace PHPAlchemist\DoctrineBehaviors\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    #[ORM\Column(nullable: true)]
    protected ?\DateTime $createdAt = null;
    #[ORM\Column(nullable: true)]
    protected ?\DateTime $updatedAt = null;

    public function getCreatedAt() : ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() : ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt) : self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
