<?php

namespace PHPAlchemist\Doctrine\BehaviorsBundle\Service;

use PHPAlchemist\Doctrine\BehaviorsBundle\Contract\DecisionServiceInterface;

class DecisionService implements DecisionServiceInterface
{
    /**
     * @param array<string, bool> $enabled keyed by the behavior names the listeners
     *                                     pass to decide(); anything absent is allowed
     */
    public function __construct(private array $enabled = [])
    {
    }

    public function decide(string $service) : bool
    {
        return $this->enabled[$service] ?? true;
    }
}
