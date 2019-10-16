<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Entity;

class Layout extends View
{
  private $type;

  public function __construct(string $type, string $name, string $path, array $data = [])
  {
    $this->type = $type;

    parent::__construct($name, $path, $data);
  }

  public function type(): string
  {
    return $this->type;
  }
}
