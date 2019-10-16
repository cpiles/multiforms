<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Renderer;

use Symfony\Component\Form\FormView;

interface RenderInterface
{
  public function __construct(string $locale, ?string $theme_name = null, ?string $theme_path = null);

  public function addTemplatePath(string $template_path): void;

  public function template(FormView $form_view, string $name, array $context): string;
}
