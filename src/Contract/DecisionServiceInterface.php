<?php

namespace PHPAlchemist\DoctrineBehaviors\Contract;

interface DecisionServiceInterface
{
    public function decide(string $service) : bool;
}