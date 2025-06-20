<?php

namespace Sem\Weben\Service;

use Exception;
use Model\Post;
use Model\PostQuery;
use Model\ThreadQuery;
use Model\UserQuery;
use Ramsey\Uuid\Uuid;

class PostService
{

  /**
   * @throws Exception
   */
  public static function createPost(string $title, string $text, string $userId, string $threadId): array
  {
    try {
      $thread = ThreadQuery::create()->findOneByUid($threadId);
      $user = UserQuery::create()->findOneByUid($userId);

      $post = new Post();
      $uuid = Uuid::uuid4()->toString();
      $createdAt = time();
      $post->setTitle($title);
      $post->setText($text);
      $post->setCreatedat($createdAt);
      $post->setUid($uuid);
      $post->setThread($thread);
      $post->setUser($user);
      $post->save();
      return $post->toArray();
    } catch (Exception $exception) {
      // echo $exception->getMessage();
      error_log($exception->getMessage());
      throw new Exception("could not create post");
    }
  }

  /**
   * @throws Exception
   */
  public static function findPostsByThreadId(string $threadId): array
  {
    $thread = ThreadQuery::create()->findOneByUid($threadId);
    $posts = PostQuery::create()->findByThreadId($thread->getId());
    $response = [];
    foreach ($posts as $post) {
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
    return [
      "posts" => $response,
      "thread" => $thread->toArray()
    ];
  }

  /**
   * @throws Exception
   */
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