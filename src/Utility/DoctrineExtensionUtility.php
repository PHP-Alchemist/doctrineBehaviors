<?php

namespace PHPAlchemist\Doctrine\BehaviorsBundle\Utility;

use PHPAlchemist\Doctrine\BehaviorsBundle\Entity\Contracts\LiableInterface;
use PHPAlchemist\Doctrine\BehaviorsBundle\Entity\Contracts\SoftDeleteableInterface;
use PHPAlchemist\Doctrine\BehaviorsBundle\Entity\Contracts\TimeStampableInterface;

class DoctrineExtensionUtility
{
    public static function isLiable(object $object) : bool
    {
        if (!$object instanceof LiableInterface) {
            return false;
        }

        return true;
    }

    public static function isSoftDeleteable(object $object) : bool
    {
        if (!$object instanceof SoftDeleteableInterface) {
            return false;
        }

        return true;
    }

    public static function isTimeStampable(object $object) : bool
    {
        if (!$object instanceof TimeStampableInterface) {
            return false;
        }

        return true;
    }
}
