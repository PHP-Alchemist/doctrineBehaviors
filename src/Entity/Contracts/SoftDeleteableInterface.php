<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts;

interface SoftDeleteableInterface
{
    public const DELETED_AT = 'deletedAt';

    public function setDeletedAt(?\DateTime $deletedAt) : self;

    public function getDeletedAt() : ?\DateTime;

    public function isDeleted() : bool;
}
