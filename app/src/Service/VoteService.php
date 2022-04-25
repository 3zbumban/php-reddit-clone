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
      $vote->setPost($post);
      $vote->setUser($user);
      $vote->save();
      return [
          "post" => $post->toArray(),
          "user" => $user->toArray(),
          "vote" => $vote->toArray()
      ];
    } catch (\Exception $exception) {
//      echo $exception->getLine();
      throw new \Exception("could not vote");
    }
  }
}