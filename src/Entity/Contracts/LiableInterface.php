<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts;

use Symfony\Component\Security\Core\User\UserInterface;

interface LiableInterface
{
    public const CREATED_BY = 'createdBy';
    public const UPDATED_BY = 'updatedBy';
    public const DELETED_BY = 'deletedBy';

    public function getCreatedBy() : ?UserInterface;

    public function setCreatedBy(?UserInterface $user) : self;

    public function getUpdatedBy() : ?UserInterface;

    public function setUpdatedBy(?UserInterface $user) : self;

    public function getDeletedBy() : ?UserInterface;

    public function setDeletedBy(?UserInterface $user) : self;
}
