<?php

namespace Sem\Weben\Service;

use Model\Comment;
use Model\PostQuery;
use Model\UserQuery;
use Ramsey\Uuid\Uuid;

class CommentService
{

  public static function commentOnPost(int $postId, string $text, int $userId)
  {
    $user = UserQuery::create()->findOneById($userId);
    $post = PostQuery::create()->findOneById($postId);

    $comment = new Comment();
    $createdAt = time();
    $uuid = Uuid::uuid4()->toString();
    $comment->setText($text);
    $comment->setCreatedat($createdAt);
    $comment->setUid($uuid);
    try {
      $comment->setUser($user);
      $comment->setPost($post);
      $comment->save();
      return $comment;
    } catch (\Exception $exception) {
      throw new \Exception("could not create comment");
    }
  }
}