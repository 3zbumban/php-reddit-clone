<?php

namespace Sem\Weben\Http;

class Request implements RequestInterface
{
    private string $url;
    private string $method;
    private array $params;
    // private $body;
    private array $headers;
    private array $queryParams;

    public function __construct()
    {
        // print 'Request created';
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        // $this->params = $_REQUEST;
        // $this->body = json_decode(file_get_contents('php://input'), true);
        $this->header = getallheaders();
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

    // public function getParams(): array
    // {
    //     return $this->params;
    // }

    // public function getParam(string $name): string
    // {
    //     return $this->params[$name];
    // }

    // public function getBody(): array
    // {
    //     return $this->body;
    // }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}