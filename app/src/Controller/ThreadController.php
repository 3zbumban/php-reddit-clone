<?php

namespace Sem\Weben\Controller;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Reddit;

class ThreadController

{
    public function list(RequestInterface $req, ResponseInterface $res): void {
        $r = new Reddit();
        $res->json($r->getPosts());
    }

    public function create(RequestInterface $req, ResponseInterface $res): void {
        $res->json([]);
    }
}