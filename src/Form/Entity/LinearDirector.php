<?php

declare(strict_types = 1);

namespace Habitissimo\MultiForm\Form\Entity;

class LinearDirector extends Director
{
  private $next;

  public function __construct(string $next)
  {
    $this->next = $next;
  }

  public function states()
  {
    return [$this->next];
  }

  public function resolveQuestion(array $data = []): string
  {
    return $this->next;
  }
}