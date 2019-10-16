<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest\Form;

use Habitissimo\MultiForm\Form\AbstractMultiForm;
use Habitissimo\MultiForm\Form\Entity\Director;
use Habitissimo\MultiForm\Form\Entity\LinearDirector;
use Habitissimo\MultiForm\Form\Entity\Step;
use Habitissimo\MultiForm\Form\Exception\InvalidFormTypeClass;
use Habitissimo\MultiForm\Form\Exception\StateIsAlreadyDefined;
use Habitissimo\MultiFormExamples\Pizza\IsVegan;
use Habitissimo\MultiFormTest\Stubs;
use PHPUnit\Framework\TestCase;

abstract class AbstractMultiFormTest extends TestCase
{
  /** @var AbstractMultiForm */
  protected $multi_form;

  /** @var Stubs */
  protected $stubs;

  protected $name;

  abstract protected function getMultiForm(): AbstractMultiForm;

  protected function setUp()
  {
    $this->multi_form = $this->getMultiForm();
    $this->stubs = new Stubs();
  }

  public function test_add_step()
  {
    $state = 'test_state';
    $type = $this->stubs->randomFormType();

    $this->multi_form->addStep($state, $type);

    $this->assertInstanceOf(Step::class, $this->multi_form->step($state));
  }

  public function test_add_step_already_exist()
  {
    $state = 'test_state';
    $type = $this->stubs->randomFormType();

    $this->multi_form->addStep($state, $type);

    $this->expectException(StateIsAlreadyDefined::class);
    $this->multi_form->addStep($state, $type);
  }

  public function test_add_step_with_invalid_type()
  {
    $state = 'test_state';
    $type = 'random_type';

    $this->expectException(InvalidFormTypeClass::class);
    $this->multi_form->addStep($state, $type);
  }

  public function test_add_step_with_director_null()
  {
    $state = 'test_state';
    $type = $this->stubs->randomFormType();

    $this->multi_form->addStep($state, $type, null);
    $step = $this->multi_form->step($state);

    $this->assertNull($step->director());
  }

  public function test_add_step_with_linear_director()
  {
    $state = 'test_state';
    $director = 'test_director';
    $type = $this->stubs->randomFormType();

    $this->multi_form->addStep($state, $type, $director);
    $step = $this->multi_form->step($state);

    $this->assertInstanceOf(LinearDirector::class, $step->director());
  }

  public function test_add_step_with_director()
  {
    $state = 'test_state';
    $director = new Director('test_positive', 'test_negative', new IsVegan());
    $type = $this->stubs->randomFormType();

    $this->multi_form->addStep($state, $type, $director);
    $step = $this->multi_form->step($state);

    $this->assertInstanceOf(Director::class, $step->director());
  }

  public function test_set_initial_step()
  {
    $state = 'test_state';
    $type = $this->stubs->randomFormType();
    $this->multi_form->addStep($state, $type, null);

    $this->multi_form->setInitialStep($state);
    $step = $this->multi_form->currentStep();

    $this->assertInstanceOf(Step::class, $step);
  }

  public function test_name_return_form_name()
  {
    $name = $this->multi_form->name();
    $this->assertEquals($this->name, $name);
  }
}