<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\StateMachine;

interface StateMachineInterface
{
  public function addTransition(string $from, string $to): void;

  public function hasTransitionsFromCurrentState(): bool;

  public function validateTransition(string $from, string $to): void;

  public function setState(string $state): void;

  public function getState(): ?string;

  public function hasState(): bool;
}
