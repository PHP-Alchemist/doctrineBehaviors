<?php

namespace PHPAlchemist\DoctrineBehaviors\Entity\Contracts;

interface SoftDeleteableInterface
{

    public const DELETED_AT = 'deletedAt';

    public function setDeletedAt(\DateTime $deletedAt = null) : self;

    public function getDeletedAt() : ?\DateTimeInterface;

    public function isDeleted() : bool;
}