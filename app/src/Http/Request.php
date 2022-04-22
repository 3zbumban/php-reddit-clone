<?php

namespace Sem\Weben\Http;

class Request implements RequestInterface
{
    private $url;
    private $method;
    private $params;
    private $body;
    private $header;
    private $queryParams;

    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = $_REQUEST;
        $this->body = json_decode(file_get_contents('php://input'), true);
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

    public function getParams(): array
    {
        return $this->params;
    }

    public function getBody(): array
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