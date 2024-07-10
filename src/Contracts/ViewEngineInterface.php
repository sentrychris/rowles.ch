<?php

namespace App\Contracts;

interface ViewEngineInterface {
  /**
   * Render a view template with data
   */
  public function render(string $template, array $data = []): string;
}