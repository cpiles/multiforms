<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form\Contract;

use Habitissimo\MultiForm\Form\AbstractMultiForm;
use Habitissimo\MultiForm\Form\Entity\Layout;
use Habitissimo\MultiForm\Form\Entity\View;

interface MultiFormRendererInterface
{
  public function __construct(AbstractMultiForm $multiForm, Layout $layout);

  public function view(string $state): View;

  public function layout(): Layout;

  public function addView(string $state, string $name = null, array $data = []): self;

  public function addStepView(string $state, View $view): self;

  public function render(string $locale): string;
}
