<?php

declare(strict_types = 1);

namespace Habitissimo\MultiForm\Form;

use Habitissimo\MultiForm\Form\Entity\Direction;
use Habitissimo\MultiForm\Form\Exception\InitialStateIsRequired;
use Habitissimo\MultiForm\Form\Type\ControlType;
use Habitissimo\MultiForm\Symfony\Forms;
use Symfony\Component\Form\FormBuilder;

class MultiForm extends AbstractMultiForm
{
  protected $handler;

  public function handleRequest(): void
  {
    if (!$this->state_machine->hasState()) {
      throw new InitialStateIsRequired();
    }

    $this->createFormAndApplyData(); // it's required call twice to get current form
    $this->createFormAndApplyData();

    if ($this->canNotContinueRequest()) {
      return;
    }

    $direction = $this->handler()->direction();
    $this->$direction();
  }

  public function isComplete(): bool
  {
    return
      $this->handler()->isLastStep() &&
      $this->form->isSubmitted() &&
      $this->form->isValid();
  }

  protected function handler(): ControlHandler
  {
    if ($this->handler !== null) {
      return $this->handler;
    }

    $this->handler = new ControlHandler($this->state_machine, $this->serializer);

    return $this->handler;
  }

  protected function getFormBuilder(array $options = []): FormBuilder
  {
    $name = $this->name();
    $step = $this->currentStep();
    $data = array_merge($this->handler()->serializerData(), $this->handler()->stateData());

    $builder = Forms::createFormFactoryBuilder()->getFormFactory()->createNamedBuilder($name);
    $builder->add($this->name(), ControlType::class, ['data' => $data]);

    $builder->get($this->name())->add($step->state(), $step->type(), $options);

    return $builder->get($this->name());
  }

  private function createFormAndApplyData(): void
  {
    $this->form = $this->form();
    $this->form->handleRequest();
    $direction = $this->form->getClickedButton()->getName();

    $this->handler()->setRequestData($this->form->getData(), $direction);
    $this->handler()->setDirection($this->form->getClickedButton()->getName());
  }

  private function canNotContinueRequest(): bool
  {
    $direction = $this->handler()->direction();
    $form_has_errors = $this->form->getErrors(true)->count() > 0;

    return ($form_has_errors || !$direction) && $direction !== (new Direction('prev'))->getValue();
  }

  private function next(): void
  {
    if ($this->handler()->isLastStep()) {
      return;
    }

    $next_state = $this->currentStep()->director()->resolveQuestion($this->handler()->data());
    $this->handler()->next($next_state);
    $this->form = $this->form();
    $this->createForm();
  }

  private function prev(): void
  {
    if ($this->handler()->isFirstStep()) {
      return;
    }

    $this->handler()->prev();
    $this->createForm();
  }

  private function reset(): void
  {
    $this->handler()->reset();

    header('location: ' . $_SERVER['HTTP_REFERER']);
    die(0);
  }
}
