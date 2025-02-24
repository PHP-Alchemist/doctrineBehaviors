<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Service;

use PHPAlchemist\Bundle\DoctrineBehaviors\Contract\DecisionServiceInterface;

class DecisionService implements DecisionServiceInterface
{
    public function decide(string $service) : bool
    {
        return true;
    }
}