<?php

namespace Sem\Weben\Service;

use Model\PostQuery;
use Model\Vote;

class VoteService
{
  public static function voteOnPost(int $postId, string $voteType, int $userId) {
    $post = PostQuery::create()->findOneById($postId);

    $vote = new Vote();
    $vote->setVote($voteType);
    try {
      $vote->setUser($userId);
      $vote->setPost($post);
      $vote->save();
      return $vote;
    } catch (\Exception $exception) {
      throw new \Exception("could not vote");
    }
  }
}