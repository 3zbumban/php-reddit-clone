<?php

namespace Sem\Weben\Controller;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\VoteService;

class VoteController
{
  public function vote(RequestInterface $req, ResponseInterface $res) {
    $vote = $req->getQueryParams()["vote"];
    $postId = (int) $req->getQueryParams()["postId"];
    $userId = (int) $req->getQueryParams()["userId"];

    $voteType = $vote === "up" ? 1 : -1;

    $voted = VoteService::voteOnPost($postId, $userId, $voteType);

    $res->setStatusCode(200);
    $res->setBody($voted);
//    $res->setBody([
//      "vote" => $voteType,
//      "postId" => $postId,
//      "userId" => $userId
//    ]);
    $res->json();
  }
}