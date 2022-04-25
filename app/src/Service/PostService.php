<?php

namespace Sem\Weben\Service;

use Model\Base\CommentQuery;
use Model\Post;
use Model\PostQuery;
use Model\ThreadQuery;
use Model\UserQuery;
use Ramsey\Uuid\Uuid;

class PostService
{

  public static function createPost(string $title, string $text, string $userId, string $threadId): array
  {
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

  public static function findPostsByThreadId(string $threadId): array
  {
    $posts = PostQuery::create()->findByThreadid($threadId);
    $response = [];
    foreach ($posts as &$post) {
      $comments = CommentService::getCommentsForPost($post->getId());
      $votes = VoteService::getVotesForPost($post->getId());

      $response[] = [
          "post" => $post->toArray(),
          "thread" => $post->getThread()->toArray(),
          "username" => $post->getUser()->getUsername(),
          "votes" => $votes,
          "comments" => $comments
      ];
    }
    return $response;
  }

  public static function findOneByUid(string $postId): array
  {
    $post = PostQuery::create()->findOneByUid($postId);
    $votes = VoteService::getVotesForPost($post->getId());
    $comments = CommentService::getCommentsForPost($post->getId());

    return [
        "post" => $post->toArray(),
        "comments" => $comments,
        "votes" => $votes
    ];
  }
}