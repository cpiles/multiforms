<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest;

class Stubs
{
  private function typesAndViews(): array
  {
    return [
      PizzaType::class => 'PizzaForm.twig',
      VegetarianType::class => 'VegetarianForm.twig',
      CheeseType::class => 'CheeseForm.twig',
    ];
  }

  public function randomFormType(): string
  {
    $types = array_keys($this->typesAndViews());

    return $types[array_rand($types)];
  }

  public function randomFormView(string $type = null): string
  {
    $type = $type ?? $this->randomFormType();
    $types_and_views = $this->typesAndViews();

    return $types_and_views[$type];
  }

  public function randomFormTypeAndView(string $type = null, string $view = null): array
  {
    $type = $type ?? $this->randomFormType();
    $view = $view ?? $this->randomFormView($type);

    return [$type, $view];
  }
}