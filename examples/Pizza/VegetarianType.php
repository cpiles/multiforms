<?php

namespace Habitissimo\MultiFormExamples\Pizza;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class VegetarianType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('pineapple', NumberType::class, [
        'label' => 'How much pineapple do you want?',
      ])
      ->add('onion', NumberType::class, [
        'label' => 'How much onion do you want?',
      ])
      ->add('mushroom', NumberType::class, [
        'label' => 'How much mushroom do you want?',
      ])
      ->add('vegan', CheckboxType::class, [
        'label' => 'Are you vegan?',
      ]);
  }
}