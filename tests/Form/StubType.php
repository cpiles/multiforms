<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class StubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
        ->add('test_quantity', NumberType::class, [
          'label' => 'How much test do you want?',
        ]);
    }
}