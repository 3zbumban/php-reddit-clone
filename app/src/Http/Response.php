<?php

namespace Sem\Weben\Http;

class Response implements ResponseInterface
{

  public function json($payload): void
  {
    header('Content-Type: application/json');
    echo json_encode($payload);
  }
}