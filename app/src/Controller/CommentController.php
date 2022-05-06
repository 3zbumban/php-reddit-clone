<?php

namespace Sem\Weben\Controller;

use Exception;
use HttpException;
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
      throw new HttpException('Missing parameters', 400);
    }

    if (empty($header['access-token'])) {
      throw new HttpException('Missing authorization header', 401);
    }
    $postId = $query["postId"];
    $userId = $query["userId"];
    $text = $body["text"];
    $jwt = $header["access-token"];
    
    try {
      $user = UserService::checkJwtAndUser($jwt, $userId);
    } catch (Exception $ex) {
      throw new HttpException($ex->getMessage(), 401);
    }
    try {
      $comment = CommentService::commentOnPost($postId, $text, $userId);
    } catch (Exception $ex) {
      throw new HttpException($ex->getMessage(), 400);
    }

    $res->setStatusCode(200);
    $res->setBody([
      "comment" => $comment,
      "user" => $user
    ]);
  }

}