<?php

namespace Habitissimo\MultiFormExamples\Pizza;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class PizzaTimeType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('time', ChoiceType::class, [
        'label' => 'when do you want pizza?',
        'choices' => [
          'now' => 'now',
          'tomorrow' => 'tomorrow',
        ],
      ]);
  }
}