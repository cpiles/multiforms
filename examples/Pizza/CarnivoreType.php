<?php

namespace Habitissimo\MultiFormExamples\Pizza;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class CarnivoreType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('beef', NumberType::class, [
        'label' => 'How much beef do you want?',
      ])
      ->add('bacon', NumberType::class, [
        'label' => 'How much bacon do you want?',
      ])
      ->add('peperoni', NumberType::class, [
        'label' => 'How much peperoni do you want?',
      ]);
  }
}