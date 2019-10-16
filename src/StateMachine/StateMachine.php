<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\StateMachine;

use Ds\Set;
use Ds\Map;

class StateMachine implements StateMachineInterface
{
  private $state;
  private $states;
  private $transitions;

  public function __construct()
  {
    $this->state = null;
    $this->states = new Set();
    $this->transitions = new Map();
  }

  public function addTransition(string $from, string $to): void
  {
    $this->states->add($from);
    $this->states->add($to);

    $values = $this->transitions->hasKey($from) ? $this->transitions->get($from) : new Set();
    $values->add($to);

    $this->transitions->put($from, $values);
  }

  public function setState(string $state): void
  {
    if ($this->states->isEmpty()) {
      $this->states->add($state);
    }

    if (!$this->states->contains($state)) {
      $valid_states = $this->states->join(', ');
      throw new InvalidStateException("Invalid state expected one of ($valid_states) got $state");
    }

    $this->state = $state;
  }

  public function getState(): ?string
  {
    return $this->state;
  }

  public function hasState(): bool
  {
    return $this->state !== null;
  }

  public function validateTransition(string $from, string $to): void
  {
    if (!$this->transitions->get($from)->contains($to)) {
      throw new CantGoException("Can't go there");
    }
  }

  public function hasTransitionsFromCurrentState(): bool
  {
    return $this->transitions->hasKey($this->state);
  }
}
