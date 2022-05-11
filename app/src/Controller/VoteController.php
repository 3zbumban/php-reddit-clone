<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\HttpException;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\UserService;
use Sem\Weben\Service\VoteService;

class VoteController
{
  /**
   * @throws HttpException
   */
  public function vote(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth - user uuid
    $query = $req->getQueryParams();
    $header = $req->getHeader();

    if (empty($header['Access-Token']) || empty($query['userId'])) {
      throw new HttpException('Unauthenticated', 401);
    }

    if (empty($query['postId']) || empty($query['userId']) || empty($query['vote'])) {
      throw new HttpException('Missing parameters', 400);
    }


    $vote = $query["vote"];
    $postId = $query["postId"];
    $userId = $query["userId"];
    $jwt = $header["Access-Token"];

    $voteType = match ($vote) {
      'up' => 1,
      'down' => -1,
      default => throw new HttpException('invalid vote type', 400),
    };

    try {
      $user = UserService::checkJwtAndUser($jwt, $userId);
    } catch (Exception $ex) {
      throw new HttpException($ex->getMessage(), 401);
    }

    try {
      $voted = VoteService::voteOnPost($postId, $userId, $voteType);
    } catch (Exception $e) {
      throw new HttpException($e->getMessage(), 400);
    }

    $res->setStatusCode(200);
    $res->setBody([
        "voted" => $voted,
        "user" => $user
    ]);
  }
}