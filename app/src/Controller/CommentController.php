<?php

namespace Sem\Weben\Controller;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;

class CommentController {

  public function find(RequestInterface $req, ResponseInterface $res): void {
    // $res->json($req->getBody());
  }

  public function create(RequestInterface $req, ResponseInterface $res): void {
    // $res->json([]);
  }

}