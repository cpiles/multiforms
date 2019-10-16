<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Type;

use Habitissimo\MultiForm\Form\Entity\Direction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ControlType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $next = (new Direction('next'))->getValue();
    $prev = (new Direction('prev'))->getValue();
    $reset = (new Direction('reset'))->getValue();

    $builder
      ->add('signature', HiddenType::class)
      ->add('value', HiddenType::class)
      ->add('step', HiddenType::class)
      ->add('direction', HiddenType::class)
      ->add($next, SubmitType::class, ['attr' => ['value' => $next]])
      ->add($prev, SubmitType::class, ['attr' => ['value' => $prev]])
      ->add($reset, SubmitType::class, ['attr' => ['value' => $reset]]);
  }
}
