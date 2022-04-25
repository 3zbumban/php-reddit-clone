<?php

namespace Sem\Weben\Http;

use Exception;

class Response implements ResponseInterface
{
  private mixed $body;
  private int $statusCode;

  public function setBody($body): void
  {
    $this->body = $body;
  }

  public function setStatusCode(int $statusCode): void
  {
    $this->statusCode = $statusCode;
  }

  public function json(): void
  {
    if (isset($this->body) && isset($this->statusCode)) {
      header('Content-Type: application/json');
      http_response_code($this->statusCode);
      echo json_encode($this->body);
    } else {
      throw new Exception('No body or status code set');
    }
  }
}