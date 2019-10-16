<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Contract;

use Habitissimo\MultiForm\Form\Entity\Step;
use Symfony\Component\Form\Form;

interface MultiFormInterface
{
  public function __construct(string $name, string $encrypt_key);

  public function isComplete(): bool;

  public function addStep(string $state, string $type, $director = null): self;

  public function setInitialStep(string $state): self;

  public function name(): string;

  public function hasStep(string $state): bool;

  public function step(string $state): Step;

  public function currentStep(): Step;

  public function form(array $options): Form;

  public function createForm(array $options = []): void;

  public function data(): array;

  public function handleRequest(): void;
}
