<?php

namespace PHPAlchemist\DoctrineBehaviors\Traits\Repository;

trait SoftDeletableTrait
{
    public function findActive()
    {
        return $this->findBy(['deletedAt' => null]);
    }

    public function findDeleted()
    {
        $query = $this->createQueryBuilder('t')
                      ->andWhere('t.deletedAt IS NOT NULL')
        ;

        return $query->getQuery()->getResult();
    }

}