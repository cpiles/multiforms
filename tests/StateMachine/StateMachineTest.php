<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest\StateMachine;

use Habitissimo\MultiForm\StateMachine\CantGoException;
use Habitissimo\MultiForm\StateMachine\InvalidStateException;
use Habitissimo\MultiForm\StateMachine\StateMachine;
use PHPUnit\Framework\TestCase;

class StateMachineTest extends TestCase
{
  /**
   * @var StateMachine
   */
  private $state_machine;

  protected function setUp()
  {
    $this->state_machine = new StateMachine();
  }

  public function test_set_state_and_return_it()
  {
    $state = 'test_state';
    $this->state_machine->setState($state);


    $this->assertEquals($state, $this->state_machine->getState());
  }

  public function test_has_not_state()
  {
    $state = 'test_state';
    $this->assertFalse($this->state_machine->hasState($state));
  }

  public function test_invalid_transition()
  {
    $state = 'test_state';
    $transition_state = 'test_transition';
    $bad_transition_state = 'test_transition_bad';

    $this->expectException(CantGoException::class);

    $this->state_machine->addTransition($state, $transition_state);
    $this->state_machine->validateTransition($state, $bad_transition_state);
  }

  public function test_valid_transition()
  {
    $state = 'test_state';
    $transition_state = 'test_transition';

    $this->state_machine->setState($state);
    $this->state_machine->addTransition($state, $transition_state);
    $this->state_machine->validateTransition($state, $transition_state);

    $this->assertTrue($this->state_machine->hasTransitionsFromCurrentState());
  }

  public function test_invalid_state_exception_when_set_second_state()
  {
    $state = 'test_state';
    $second_state = 'second_state';

    $this->expectException(InvalidStateException::class);

    $this->state_machine->setState($state);
    $this->state_machine->setState($second_state);
  }
}
