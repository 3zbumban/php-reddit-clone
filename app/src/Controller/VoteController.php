<?php

namespace Sem\Weben\Controller;

use Exception;
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
      throw new Exception('Missing parameters');
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
        throw new Exception('invalid vote type');
    }

    // $voteType = $vote === "up" ? 1 : -1;

    $voted = VoteService::voteOnPost($postId, $userId, $voteType);

    $res->setStatusCode(200);
    $res->setBody($voted);
  }
}