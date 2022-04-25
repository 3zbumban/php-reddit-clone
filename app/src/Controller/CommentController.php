<?php

namespace Sem\Weben\Controller;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\CommentService;

class CommentController
{

//  public function find(RequestInterface $req, ResponseInterface $res): void {
//    // $res->json($req->getBody());
//  }

  public function create(RequestInterface $req, ResponseInterface $res): void
  {
    $query = $req->getQueryParams();
    $postId = $query["postId"];
    $userId = $query["userId"];
    $text = $req->getBody()["text"];

    $comment = CommentService::commentOnPost($postId, $text, $userId);

    $res->setStatusCode(200);
    $res->setBody($comment->toArray());
    $res->json();
  }

}