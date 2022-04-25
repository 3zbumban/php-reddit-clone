<?php

namespace Sem\Weben\Service;

use Model\Base\CommentQuery;
use Model\UserQuery;
use Model\Vote;
use Model\PostQuery;
use Model\VoteQuery;

class VoteService
{
  public static function voteOnPost(int $postId, int $userId, int $voteType)
  {
    $post = PostQuery::create()->findOneById($postId);
    $user = UserQuery::create()->findOneById($userId);
    $voteTest = VoteQuery::create()->filterByPostid($post->getId())->findByUserid($user->getId());

//    echo $voteTest;
    if (empty($voteTest->toArray())) {
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
    } else {
      throw new \Exception("already voted");
    }
  }

  public static function getVotesForPost(int $postId) {
    $post = PostQuery::create()->findOneById($postId);
    $votesCount = VoteQuery::create()->findByPostid($post->getId())->count();
    $votesUp = VoteQuery::create()->filterByVote(1)->findByPostid($post->getId())->count();
    $votes = VoteQuery::create()->findByPostid($post->getId());
    $voting = 1;
    foreach ($votes as &$vote) {
      $voting += $vote->getVote();
    }
    return [
        "voting" => $voting,
        "count" => $votesCount,
        "up" => $votesUp,
        "down" => $votesCount - $votesUp
    ];
  }
}