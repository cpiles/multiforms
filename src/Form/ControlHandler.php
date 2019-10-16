<?php

declare(strict_types = 1);

namespace Habitissimo\MultiForm\Form;

use Ds\Set;
use Habitissimo\MultiForm\Form\Contract\ControlHandlerInterface;
use Habitissimo\MultiForm\Serializer\Serializer;
use Habitissimo\MultiForm\StateMachine\StateMachine;

class ControlHandler implements ControlHandlerInterface
{
  private $state_machine;
  private $serializer;
  private $historic;

  private $direction;
  private $data = [];

  public function __construct(StateMachine $state_machine, Serializer $serializer)
  {
    $this->state_machine = $state_machine;
    $this->serializer = $serializer;
    $this->historic = new Set();
  }

  public function isLastStep(): bool
  {
    return !$this->state_machine->hasTransitionsFromCurrentState();
  }

  public function isFirstStep(): bool
  {
    return $this->historic->isEmpty();
  }

  public function setRequestData(array $data, string $direction): void
  {
    $this->state_machine->setState($data["step"]);
    $this->direction = $direction;
    $deserialize_data = $this->serializer->deserialize($data['value'], $data['signature']);
    $this->data = array_merge($this->data, $deserialize_data['data']);
    $this->historic = new Set($deserialize_data['historic']);

    if (isset($data[$this->state_machine->getState()])) {
      $this->data[$this->state_machine->getState()] = $data[$this->state_machine->getState()];
    }
  }

  public function direction(): ?string
  {
    return $this->direction;
  }

  public function setDirection(string $direction): void
  {
    $this->direction = $direction;
  }

  public function serializerData(): array
  {
    $serializer_data = [
      'data' => $this->data,
      'historic' => $this->historic->toArray(),
    ];

    $data = $this->serializer->serialize($serializer_data);
    $data['step'] = $this->state_machine->getState();

    return $data;
  }

  public function stateData(): array
  {
    $state = $this->state_machine->getState();

    return [$state => $this->data[$state] ?? []];
  }

  public function data(): array
  {
    return $this->data;
  }

  public function next(string $state): void
  {
    if ($this->isFirstStep()) {
      $this->historic->add($this->state_machine->getState());
    }

    $this->state_machine->validateTransition($this->state_machine->getState(), $state);
    $this->historic->add($state);
    $this->state_machine->setState($state);
  }

  public function prev(): void
  {
    $current = $this->historic->last();
    $this->historic->remove($current);

    $state = $this->isFirstStep() ? $current : $this->historic->last();
    $this->state_machine->setState($state);
  }

  public function reset(): void
  {
    $this->historic = new Set();
  }
}
