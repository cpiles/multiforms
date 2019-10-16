<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Contract;

use Habitissimo\MultiForm\Serializer\Serializer;
use Habitissimo\MultiForm\StateMachine\StateMachine;

interface ControlHandlerInterface
{
  public function __construct(StateMachine $state_machine, Serializer $serializer);

  public function isLastStep(): bool;

  public function isFirstStep(): bool;

  public function setRequestData(array $data, string $direction): void;

  public function direction(): ?string;

  public function setDirection(string $direction): void;

  public function serializerData(): array;

  public function stateData(): array;

  public function data(): array;

  public function next(string $state): void;

  public function prev(): void;

  public function reset(): void;
}
