<?php

namespace Sem\Weben;

class Router {
  private string $basePath;
  
  function __construct(string $basePath) {
    print "In constructor :)\n";
    $this->basePath = $basePath;
  }

  function getBase() {
    return $this->basePath;
  }
}