<?php

namespace PHPAlchemist\Doctrine\BehaviorsBundle\Contract;

interface DecisionServiceInterface
{
    public function decide(string $service) : bool;
}
