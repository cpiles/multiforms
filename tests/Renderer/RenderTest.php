<?php

declare(strict_types = 1);

namespace Habitissimo\MultiFormTest\Renderer;

use Habitissimo\MultiForm\Form\Type\ControlType;
use Habitissimo\MultiForm\Renderer\Render;
use Habitissimo\MultiForm\Symfony\Forms;
use Habitissimo\MultiFormTest\Stubs;
use PHPUnit\Framework\TestCase;

class RenderTest extends TestCase
{
  private $render;

  protected function setUp(): void
  {
    $this->render = new Render();
  }

  public function test_has_default_theme_path()
  {
    $this->assertIsString($this->render->getDefaultThemePath());
  }

  public function test_has_default_locale()
  {
    $this->assertEquals('en', $this->render->getLocale());
  }
}