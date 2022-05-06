<?php

namespace Sem\Weben\Controller;

use Exception;
use HttpException;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\VoteService;

class VoteController
{
  public function vote(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth - user uuid
    $query = $req->getQueryParams();

    if (empty($query['postId']) || empty($query['userId']) || empty($query['vote'])) {
      throw new HttpException('Missing parameters', 400);
    }

    $vote = $query["vote"];
    $postId = $query["postId"];
    $userId = $query["userId"];

    switch ($vote) {
      case 'up':
        $voteType = 1;
        break;
      case 'down':
        $voteType = -1;
        break;
      default:
        throw new HttpException('invalid vote type', 400);
    }

    // $voteType = $vote === "up" ? 1 : -1;
    try {
      $voted = VoteService::voteOnPost($postId, $userId, $voteType);
    } catch (Exception $e) {
      throw new HttpException($e->getMessage(), 400);
    }

    $res->setStatusCode(200);
    $res->setBody($voted);
  }
}