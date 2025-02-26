<?php

namespace PHPAlchemist\Doctrine\BehaviorsBundle\Trait;

use Doctrine\ORM\Mapping as ORM;

trait SoftDeleteableTrait
{
    #[ORM\Column(nullable: true)]
    protected ?\DateTime $deletedAt = null;

    public function getDeletedAt() : ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt) : self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function isDeleted() : bool
    {
        return $this->deletedAt !== null;
    }
}
