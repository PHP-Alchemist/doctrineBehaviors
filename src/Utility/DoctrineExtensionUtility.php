<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Utility;

use PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts\LiableInterface;
use PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts\SoftDeleteableInterface;
use PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts\TimeStampableInterface;

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
