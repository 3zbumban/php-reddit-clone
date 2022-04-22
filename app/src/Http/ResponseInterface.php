<?php

declare(strict_types=1);

namespace Sem\Weben\Http;

interface ResponseInterface {
//  public function send(): int;
  public function json($payload): void;
}