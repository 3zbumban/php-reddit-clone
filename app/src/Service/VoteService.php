<?php

namespace Sem\Weben\Service;

use Exception;
use Model\UserQuery;
use Model\Vote;
use Model\PostQuery;
use Model\VoteQuery;

class VoteService
{
  /**
   * @throws Exception
   */
  public static function voteOnPost(string $postId, string $userId, int $voteType): array
  {
    $post = PostQuery::create()->findOneByUid($postId);
    if (!$post) {
      throw new Exception("Post not found");
    }
    $user = UserQuery::create()->findOneByUid($userId);
    if (!$user) {
      throw new Exception("User not found");
    }
    $voteTest = VoteQuery::create()->filterByPostid($post->getId())->findByUserid($user->getId());

    if (empty($voteTest->toArray())) {
      $vote = new Vote();
      $vote->setVote($voteType);

      try {
        $vote->setPost($post);
        $vote->setUser($user);
        $vote->save();
        return [
            "post" => $post->toArray(),
            "user" => [
                "username" => $user->getUsername(),
                "uid" => $user->getUid()
            ],
            "vote" => $vote->toArray()
        ];
      } catch (Exception $exception) {
        throw new Exception("could not vote");
      }
    } else {
      throw new Exception("already voted");
    }
  }

  public static function getVotesForPost(int $postId): array
  {
    $post = PostQuery::create()->findOneById($postId);
    if (!$post) {
      throw new Exception("Post not found");
    }
    $votesCount = VoteQuery::create()->findByPostid($post->getId())->count();
    $votesUp = VoteQuery::create()->filterByVote(1)->findByPostid($post->getId())->count();
    $votes = VoteQuery::create()->findByPostid($post->getId());
    $voting = 1;
    foreach ($votes as $vote) {
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