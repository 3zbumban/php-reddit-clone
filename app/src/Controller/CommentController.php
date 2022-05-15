<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\HttpException;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\CommentService;
use Sem\Weben\Service\UserService;

class CommentController
{

  /**
   * @throws HttpException
   */
  public function create(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth - done?
    $query = $req->getQueryParams();
    $body = $req->getBody();
    $header = $req->getHeader();

    if (empty($header['Access-Token']) || empty($query['userId'])) {
      throw new HttpException('Unauthenticated', 401);
    }

    if (empty($query['postId']) || empty($body['text'])) {
      throw new HttpException('missing parameters', 400);
    }

    $postId = $query["postId"];
    $userId = $query["userId"];
    $text = $body["text"];
    $jwt = $header["Access-Token"];

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