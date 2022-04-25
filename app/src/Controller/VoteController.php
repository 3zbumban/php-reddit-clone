<?php

namespace Sem\Weben\Controller;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\VoteService;

class VoteController
{
  public function create(RequestInterface $req, ResponseInterface $res) {
    $vote = $req->getQueryParams()["vote"];
    $postId = $req->getQueryParams()["postId"];
    $userId = $req->getQueryParams()["userId"];

    $voted = VoteService::voteOnPost($postId, $vote, $userId);

    $res->setStatusCode(200);
    $res->setBody($voted);
    $res->json();
  }
}