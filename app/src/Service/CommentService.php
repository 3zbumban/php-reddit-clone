<?php

namespace Sem\Weben\Service;

use Exception;
use Model\CommentQuery;
use Model\Comment;
use Model\PostQuery;
use Model\UserQuery;
use Propel\Runtime\Exception\PropelException;
use Ramsey\Uuid\Uuid;

class CommentService
{

  /**
   * @throws Exception
   */
  public static function commentOnPost(string $postId, string $text, string $userId): array
  {
    try {
      $user = UserQuery::create()->findOneByUid($userId);
      $post = PostQuery::create()->findOneByUid($postId);

      $comment = new Comment();
      $createdAt = time();
      $uuid = Uuid::uuid4()->toString();
      $comment->setText($text);
      $comment->setCreatedat($createdAt);
      $comment->setUid($uuid);
      $comment->setUser($user);
      $comment->setPost($post);
      $comment->save();
      return $comment->toArray();
    } catch (Exception $exception) {
      error_log($exception->getMessage());
      throw new Exception("could not create comment");
    }
  }

  /**
   * @throws PropelException
   */
  public static function getCommentsForPost(int $postId): array
  {
    $comments = CommentQuery::create()->findByPostid($postId);
    $response = [];
    foreach ($comments as $comment) {
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