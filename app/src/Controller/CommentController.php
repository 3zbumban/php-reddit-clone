<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\CommentService;
use Sem\Weben\Service\UserService;

class CommentController
{

  public function create(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth - user uuid
    $query = $req->getQueryParams();
    $body = $req->getBody();
    $header = $req->getHeader();

    if (empty($query['postId']) || empty($query['userId']) || empty($body['text'])) {
      throw new Exception('Missing parameters');
    }

    if (empty($header['access-token'])) {
      throw new Exception('Missing authorization header');
    }
    $postId = $query["postId"];
    $userId = $query["userId"];
    $text = $body["text"];
    $jwt = $header["access-token"];
    
    $user = UserService::checkJwtAndUser($jwt, $userId);
    $comment = CommentService::commentOnPost($postId, $text, $userId);

    $res->setStatusCode(200);
    $res->setBody($comment);
  }

}