<?php

declare(strict_types=1);

namespace Sem\Weben\Http;

interface RequestInterface {
  public function getUrl(): string;
  public function getMethod(): string;
  // public function getParams(): array;
  // public function getBody(): array;
  public function getHeader(): array;
  public function getQueryParams(): array;
}