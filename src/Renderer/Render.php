<?php

declare(strict_types = 1);
namespace Habitissimo\MultiForm\Renderer;

use Symfony\Bridge\Twig\Extension\CsrfExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

class Render implements RenderInterface
{
  private $locale;
  private $template_paths;
  private $template_name;

  public function __construct(string $locale = 'en', ?string $theme_name = null, ?string $theme_path = null)
  {
    $this->locale = $locale;
    $this->template_paths = new \Ds\Set();
    $this->template_name = $theme_path ?? 'base.twig';

    $this->addTemplatePath($theme_path ?? $this->getDefaultThemePath());
  }

  public function addTemplatePath(string $template_path): void
  {
    $this->template_paths->add($template_path);
  }

  public function getDefaultThemePath(): string
  {
    return __DIR__ . DIRECTORY_SEPARATOR . 'Themes';
  }

  public function getLocale(): string
  {
    return $this->locale;
  }

  public function template(FormView $view, string $name, array $context): string
  {
    $context_form_key = 'form';
    if (isset($context[$context_form_key])) {
      throw new InvalidContextException("Property $context_form_key can't be declared in context");
    }

    $template_paths = $this->template_paths->toArray();
    $twig = new Environment(new FilesystemLoader($template_paths));
    $renderer_engine = new TwigRendererEngine([$this->template_name], $twig);

    $CSRF_extension = new CsrfTokenManager();
    $twig->addExtension(new FormExtension());
    $twig->addExtension(new CsrfExtension());
    $twig->addExtension(new TranslationExtension(new Translator($this->locale)));
    $twig->addRuntimeLoader(new FactoryRuntimeLoader([
      FormRenderer::class => function () use ($renderer_engine, $CSRF_extension) {
        return new FormRenderer($renderer_engine, $CSRF_extension);
      },
    ]));

    $context[$context_form_key] = $view;

    return $twig->render($name, $context);
  }
}
