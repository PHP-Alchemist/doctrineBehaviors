<?php

namespace PHPAlchemist\DoctrineBehaviors\Traits;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

trait LiableTrait
{
    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL', name: 'created_by')]
    protected ?User $createdBy = null;
    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL', name: 'updated_by')]
    protected ?User $updatedBy = null;

    #[ORM\ManyToOne(targetEntity: UserInterface::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL', name: 'deleted_by')]
    protected ?User $deletedBy = null;

    public function getCreatedBy() : ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy) : self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy() : ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy) : self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getDeletedBy() : ?User
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?User $deletedBy) : self
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }
}
