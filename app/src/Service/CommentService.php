<?php

namespace Sem\Weben\Service;

use Model\Base\CommentQuery;
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

  public static function getCommentsForPost(int $postId) {
    $comments = CommentQuery::create()->findByPostid($postId);
    $response = [];
    foreach ($comments as &$comment) {
      $user = UserQuery::create()->findOneById($comment->getUserid());
      $response[] = array(
          "text" => $comment->getText(),
          "uid" => $comment->getUid(),
          "user" => [
              "username" => $user->getUsername()
          ],
          "createdAt" => $comment->getCreatedat()
      );
    }
    return $response;
  }
}