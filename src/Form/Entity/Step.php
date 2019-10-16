<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Entity;

class Step
{
  protected $type;
  protected $state;
  protected $director;

  public function __construct(
    string $state,
    string $type,
    Director $director = null
  ) {
    $this->type = $type;
    $this->state = $state;
    $this->director = $director;
  }

  public function type(): string
  {
    return $this->type;
  }

  public function state(): string
  {
    return $this->state;
  }

  public function director(): ?Director
  {
    return $this->director;
  }
}
