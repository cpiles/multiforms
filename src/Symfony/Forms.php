<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Symfony;

use Symfony\Component\Form\FormFactoryBuilderInterface;

final class Forms
{
  public static function createFormFactoryBuilder(): FormFactoryBuilderInterface
  {
    return new FormFactoryBuilder();
  }
}
