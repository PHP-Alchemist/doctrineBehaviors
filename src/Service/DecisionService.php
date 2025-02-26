<?php

namespace PHPAlchemist\Doctrine\BehaviorsBundle\Service;

use PHPAlchemist\Doctrine\BehaviorsBundle\Contract\DecisionServiceInterface;

class DecisionService implements DecisionServiceInterface
{
    public function decide(string $service) : bool
    {
        return true;
    }
}
