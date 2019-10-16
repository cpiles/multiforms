<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Form;

use Ds\Map;
use Habitissimo\MultiForm\Form\Contract\MultiFormRendererInterface;
use Habitissimo\MultiForm\Form\Entity\Layout;
use Habitissimo\MultiForm\Form\Entity\View;
use Habitissimo\MultiForm\Form\Exception\ViewStateNotFound;
use Habitissimo\MultiForm\Form\Type\ControlType;
use Habitissimo\MultiForm\Renderer\Render;

class MultiFormRenderer implements MultiFormRendererInterface
{
  private $multiform;
  private $layout;
  private $views;

  public function __construct(AbstractMultiForm $multiform, Layout $layout = null)
  {
    $this->multiform = $multiform;
    $this->layout = $this->configureLayout($layout);
    $this->views = new Map();
  }

  public function view(string $state): View
  {
    if (!$this->views->hasKey($state)) {
      throw new ViewStateNotFound($state);
    }

    return $this->views->get($state);
  }

  public function layout(): Layout
  {
    return $this->layout;
  }

  public function addView(string $state, string $name = null, array $data = []): MultiFormRendererInterface
  {
    $step = $this->multiform->step($state);
    [$name, $path] = $this->configureView($step->type(), $name);

    $this->views->put($state, new View($name, $path, $data));

    return $this;
  }

  public function addStepView(string $state, View $view): MultiFormRendererInterface
  {
    $this->multiform->step($state);

    $this->views->put($state, $view);

    return $this;
  }

  public function render(string $locale): string
  {
    $step = $this->multiform->currentStep();
    $view = $this->view($step->state());
    $form = $this->multiform->form($view->data());

    $context = new Map();
    $context->put('multiform_step', $view->name());
    $context->put('multiform_state', $step->state());

    $render = new Render($locale);
    $render->addTemplatePath($this->layout()->path());
    $render->addTemplatePath($view->path());

    return $render->template($form->createView(), $this->layout()->name(), $context->toArray());
  }

  private function configureView(string $type, string $name = null, string $path = null): array
  {
    $type_class = (new \ReflectionClass($type));
    $name = $name ?? basename($type_class->getFileName(), '.php') . '.twig';
    $path = $path ?? dirname($type_class->getFileName()) . DIRECTORY_SEPARATOR;

    return [$name, $path];
  }

  private function configureLayout(Layout $layout = null): Layout
  {
    if ($layout !== null) {
      return $layout;
    }

    $layout_type = ControlType::class;
    [$name, $path] = $this->configureView($layout_type);

    return new Layout($layout_type, $name, $path);
  }
}
