<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Entity;

use MyCLabs\Enum\Enum;

class Direction extends Enum
{
  private const NEXT = 'next';
  private const PREV = 'prev';
  private const RESET = 'reset';
}
