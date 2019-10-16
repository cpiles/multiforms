<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form;

use Ds\Map;
use Habitissimo\MultiForm\Form\Contract\MultiFormInterface;
use Habitissimo\MultiForm\Form\Entity\LinearDirector;
use Habitissimo\MultiForm\Form\Entity\Step;
use Habitissimo\MultiForm\Form\Exception\InvalidFormTypeClass;
use Habitissimo\MultiForm\Form\Exception\StateIsAlreadyDefined;
use Habitissimo\MultiForm\Form\Exception\StateIsNotDefined;
use Habitissimo\MultiForm\Serializer\Serializer;
use Habitissimo\MultiForm\StateMachine\StateMachine;
use Symfony\Component\Form\Form;

abstract class AbstractMultiForm implements MultiFormInterface
{
  protected $control;
  protected $builder;

  protected $name;
  protected $form;

  protected $steps;
  protected $state_machine;
  protected $serializer;

  public function __construct(string $name, string $encrypt_key)
  {
    $this->name = $name;
    $this->steps = new Map();
    $this->state_machine = new StateMachine();
    $this->serializer = new Serializer($encrypt_key);
  }

  public function addStep(string $state, string $type, $director = null): MultiFormInterface
  {
    if ($this->hasStep($state)) {
      throw new StateIsAlreadyDefined($state);
    }

    if (!class_exists($type)) {
      throw new InvalidFormTypeClass($type);
    }

    if ($director !== null) {
      if (is_string($director)) {
        $director = new LinearDirector($director);
      }

      foreach ($director->states() as $director_state) {
        $this->state_machine->addTransition($state, $director_state);
      }
    }

    $this->steps->put($state, new Step($state, $type, $director));

    return $this;
  }

  public function setInitialStep(string $state): MultiFormInterface
  {
    $this->state_machine->setState($state);

    return $this;
  }

  public function name(): string
  {
    return $this->name;
  }

  public function hasStep(string $state): bool
  {
    return $this->steps->hasKey($state);
  }

  public function step(string $state): Step
  {
    if (!$this->hasStep($state)) {
      throw new StateIsNotDefined($state);
    }

    return $this->steps->get($state);
  }

  public function currentStep(): Step
  {
    return $this->steps->get($this->state_machine->getState());
  }

  public function form(array $options = []): Form
  {
    return $this->getFormBuilder($options)->getForm();
  }

  public function createForm(array $options = []): void
  {
    $this->form = $this->form($options);
  }

  public function data(): array
  {
    return $this->handler()->data();
  }
}
