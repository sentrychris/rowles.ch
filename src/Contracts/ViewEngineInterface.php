<?php

namespace Rowles\Contracts;

interface ViewEngineInterface {
  /**
   * 
   */
  public function render(string $template, array $data = []): string;
}