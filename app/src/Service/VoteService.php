<?php

namespace Sem\Weben\Service;

use Model\UserQuery;
use Model\Vote;
use Model\PostQuery;

class VoteService
{
  public static function voteOnPost(int $postId, int $userId, int $voteType)
  {
    $post = PostQuery::create()->findOneById($postId);
    $user = UserQuery::create()->findOneById($userId);

    $vote = new Vote();
    $vote->setVote($voteType);

    try {
      $vote->setUser($user);
      $vote->setPost($post);
//      $vote->save();
      return [
          "post" => $post->toArray(),
          "user" => $user->toArray(),
          "vote" => $vote->toArray()
      ];
    } catch (\Exception $exception) {
      echo $exception->getTraceAsString();
      throw new \Exception("could not vote");
    }
  }
}