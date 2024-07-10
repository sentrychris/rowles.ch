<?php

namespace App\Contracts;

interface ViewEngineInterface {
  /**
   * 
   */
  public function render(string $template, array $data = []): string;
}