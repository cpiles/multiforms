<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Entity;

use Habitissimo\MultiForm\Form\Contract\Invokable;

class Director
{
  private $positive;
  private $negative;
  private $invokable;

  public function __construct(string $positive, string $negative, Invokable $invokable)
  {
    $this->positive = $positive;
    $this->negative = $negative;
    $this->invokable = $invokable;
  }

  public function states()
  {
    return [$this->positive, $this->negative];
  }

  public function resolveQuestion(array $data = []): string
  {
    $invokable_class = $this->invokable;

    return $invokable_class($data) ? $this->positive : $this->negative;
  }
}
