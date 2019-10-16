<?php
namespace Habitissimo\MultiFormExamples\Pizza;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PizzaType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name', TextType::class, [
        'label' => 'Pizza name',
      ])
      ->add('type', ChoiceType::class, [
        'label' => 'Choose a pizza',
        'choices' => [
          'vegetarian' => 'vegetarian',
          'carnivore' => 'carnivore',
        ],
      ]);
  }

  public function finishView(FormView $view, FormInterface $form, array $options)
  {
    $view->vars['track_event'] = $options['track_event'];
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'track_event' => 'default_track_event',
    ]);
  }
}
