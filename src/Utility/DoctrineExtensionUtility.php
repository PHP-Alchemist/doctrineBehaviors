<?php

namespace PHPAlchemist\DoctrineBehaviors\Utility;

use PHPAlchemist\DoctrineBehaviors\Entity\Contracts\LiableInterface;
use PHPAlchemist\DoctrineBehaviors\Entity\Contracts\SoftDeleteableInterface;
use PHPAlchemist\DoctrineBehaviors\Entity\Contracts\TimeStampableInterface;

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
