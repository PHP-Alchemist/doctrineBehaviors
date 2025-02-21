<?php

namespace PHPAlchemist\DoctrineBehaviors\Service;

use PHPAlchemist\DoctrineBehaviors\Contract\DecisionServiceInterface;

class DecisionService implements DecisionServiceInterface
{
    public function decide(string $service) : bool
    {
        return true;
    }
}
