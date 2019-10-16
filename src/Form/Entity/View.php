<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Entity;

class View
{
  protected $path;
  protected $name;
  protected $data;

  public function __construct(string $name, string $path, array $data)
  {
    $this->path = $path;
    $this->name = $name;
    $this->data = $data;
  }

  public function name(): string
  {
    return $this->name;
  }

  public function path(): string
  {
    return $this->path;
  }

  public function data(): array
  {
    return $this->data;
  }
}
