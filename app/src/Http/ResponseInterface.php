<?php

namespace Sem\Weben\Http;

interface ResponseInterface {
  public function send(): int;
  public function json(): int;
}