<?php

namespace PHPAlchemist\DoctrineBehaviors\Contracts;

interface TimeStampableInterface
{

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    public function getCreatedAt() : ?\DateTime;

    public function setCreatedAt(\DateTime $createdAt);

    public function getUpdatedAt() : ?\DateTime;

    public function setUpdatedAt(\DateTime $updatedAt);

}