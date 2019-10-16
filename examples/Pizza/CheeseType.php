<?php

namespace Habitissimo\MultiFormExamples\Pizza;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class CheeseType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('cheese', CheckboxType::class, [
        'label' => 'Do you want cheese?',
      ]);
  }
}