<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Contract;

interface Invokable
{
  public function __invoke($args): bool;
}
