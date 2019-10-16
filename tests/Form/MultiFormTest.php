<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest\Form;

use Habitissimo\MultiForm\Form\AbstractMultiForm;
use Habitissimo\MultiForm\Form\MultiForm;

class MultiFormTest extends AbstractMultiFormTest
{
  protected function setUp(): void
  {
    $this->name = 'test_form';
    parent::setUp();
  }

  protected function getMultiForm(): AbstractMultiForm
  {
    return new MultiForm($this->name, 'secret_test_key');
  }
}