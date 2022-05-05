<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\CommentService;

class CommentController
{

  public function create(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth - user uuid
    $query = $req->getQueryParams();
    $body = $req->getBody();
    if (empty($query['postId']) || empty($query['userId']) || empty($body['text'])) {
      throw new Exception('Missing parameters');
    }
    $postId = $query["postId"];
    $userId = $query["userId"];
    $text = $req->getBody()["text"];
    
    // $authenticated = UserService::checkJwtAndUser();
    $comment = CommentService::commentOnPost($postId, $text, $userId);

    $res->setStatusCode(200);
    $res->setBody($comment);
  }

}