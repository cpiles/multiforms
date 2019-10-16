<?php
namespace Habitissimo\MultiFormExamples\Pizza;

use Habitissimo\MultiForm\Form\Contract\Invokable;

class IsVegetarianPizza implements Invokable
{
  public function __invoke($args): bool
  {
    return $args['pizza']['type'] === 'vegetarian';
  }
}
