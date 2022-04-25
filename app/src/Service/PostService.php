<?php

namespace Sem\Weben\Service;

use Model\Base\CommentQuery;
use Model\Post;
use Model\PostQuery;
use Model\ThreadQuery;
use Model\UserQuery;
use Model\VoteQuery;
use Ramsey\Uuid\Uuid;

class PostService {

  public static function createPost(string $title, string $text, string $userId, string $threadId) {
    $thread = ThreadQuery::create()->findOneByUid($threadId);
    $user = UserQuery::create()->findOneById($userId);

    $post = new Post();
    $uuid = Uuid::uuid4()->toString();
    $createdAt = time();
    $post->setTitle($title);
    $post->setText($text);
    $post->setCreatedat($createdAt);
    $post->setUid($uuid);
    try {
      $post->setThread($thread);
      $post->setUser($user);
      $post->save();
      return $post->toArray();
    } catch (\Exception $exception) {
      throw new \Exception("could not create post");
    }
  }

  public static function findPostsByThreadId(string $threadId) {
    $posts = PostQuery::create()->findByThreadid($threadId);
    $response = [];
    foreach ($posts as &$post) {
      $comments = CommentQuery::create()->findByPostid($post->getId());
      $tmp = [
          "post" => $post->toArray(),
          "thread" => $post->getThread()->toArray(),
          "user" => $post->getUser()->toArray(),
          "comments" => $comments->toArray()
      ];
      array_push($response, (object) $tmp);
    }
    return $response;
  }

  public static function findOneByUid(string $postId) {
    $post = PostQuery::create()->findOneByUid($postId);
    $votes = VoteService::getVotesForPost($post->getId());
    $comments = CommentQuery::create()->findByPostid($post->getId());
//    $votesCount = VoteQuery::create()->findByPostid($post->getId())->count();
//    $votesUp = VoteQuery::create()->filterByVote(1)->findByPostid($post->getId())->count();
//    $votes = VoteQuery::create()->findByPostid($post->getId());
//    $voting = 1;
//    foreach ($votes as &$vote) {
//      $voting += $vote->getVote();
//    }
    return [
        "post" => $post->toArray(),
        "comments" => $comments->toArray(),
        "votes" => $votes
//        "votes" => [
//            "voting" => $voting,
//            "count" => $votesCount,
//            "up" => $votesUp,
//            "down" => $votesCount - $votesUp
//        ]
    ];
  }
}