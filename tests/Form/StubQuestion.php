<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest\Form;

use Habitissimo\MultiForm\Form\Contract\Invokable;

class StubQuestion implements Invokable
{
  public function __invoke($args): bool
  {
    return $args['stub']['test'];
  }
}
