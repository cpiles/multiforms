<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Symfony;

use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormFactoryBuilder as SymfonyFormFactoryBuilder;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Validator\Validation;

class FormFactoryBuilder extends SymfonyFormFactoryBuilder
{
  public function __construct()
  {
    $this
      ->addExtension(new CoreExtension())
      ->addExtension(new CsrfExtension(new CsrfTokenManager()))
      ->addExtension(new ValidatorExtension(Validation::createValidator()));
  }
}
