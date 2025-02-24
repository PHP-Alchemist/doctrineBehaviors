<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

trait LiableTrait
{
    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL', name: 'created_by')]
    protected ?UserInterface $createdBy = null;
    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL', name: 'updated_by')]
    protected ?UserInterface $updatedBy = null;

    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL', name: 'deleted_by')]
    protected ?UserInterface $deletedBy = null;

    public function getCreatedBy() : ?UserInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?UserInterface $createdBy) : self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy() : ?UserInterface
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?UserInterface $updatedBy) : self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getDeletedBy() : ?UserInterface
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?UserInterface $deletedBy) : self
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }
}
