<?php

declare(strict_types=1);

namespace Sem\Weben\Http;

interface ResponseInterface {
  public function setBody($body): void;
  // public function getBody(): mixed;
  public function setStatusCode(int $statusCode): void;
  public function json(): void;
}