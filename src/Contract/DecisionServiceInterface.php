<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Contract;

interface DecisionServiceInterface
{
    public function decide(string $service) : bool;
}
