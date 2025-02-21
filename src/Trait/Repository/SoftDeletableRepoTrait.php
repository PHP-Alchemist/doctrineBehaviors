<?php

namespace PHPAlchemist\DoctrineBehaviors\Trait\Repository;

trait SoftDeletableRepoTrait
{
    public function findActive()
    {
        return $this->findBy(['deletedAt' => null]);
    }

    public function findDeleted()
    {
        $query = $this->createQueryBuilder('t')
                      ->andWhere('t.deletedAt IS NOT NULL');

        return $query->getQuery()->getResult();
    }
}
