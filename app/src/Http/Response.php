<?php

namespace Sem\Weben\Http;

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
      header("Access-Control-Allow-Origin: *");
      header("Content-Type: application/json; charset=UTF-8");

      http_response_code($this->statusCode);
      echo json_encode($this->body);
    } else {
      // todo: is this good?
      http_response_code(204);
      echo json_encode([
          "message" => "nothing to see here 👀"
      ]);
    }
  }
}