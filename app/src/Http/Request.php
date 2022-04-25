<?php

declare(strict_types=1);

namespace Sem\Weben\Http;

class Request implements RequestInterface
{
  private string $url;
  private string $method;
  private array $pathParams;
  private $body;
  private array $headers;
  private array $queryParams;
  private array|false $header;

  public function __construct()
  {
    // print 'Request created';
    $this->url = $_SERVER['REQUEST_URI'];
    $this->method = $_SERVER['REQUEST_METHOD'];
    // $this->params = $_SERVER['REQUEST_PARAMS'];
    $this->body = json_decode(file_get_contents('php://input'), true);
    $this->header = getallheaders();
    $this->pathParams = array_filter(explode('/', strtok($this->url, '?')));
    $this->queryParams = $_GET;
  }

  public function getUrl(): string
  {
    return $this->url;
  }

  public function getMethod(): string
  {
    return $this->method;
  }

  public function getQueryParam(string $key): string
  {
    return $this->queryParams[$key];
  }

  public function getPathParams(): array
  {
    return $this->pathParams;
  }

  public function getBody(): mixed
  {
    return $this->body;
  }

  public function getHeader(): array
  {
    return $this->header;
  }

  public function getQueryParams(): array
  {
    return $this->queryParams;
  }
}