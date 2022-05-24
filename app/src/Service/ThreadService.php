<?php

namespace Sem\Weben\Service;

use Exception;
use Model\Thread;
use Model\ThreadQuery;
use Ramsey\Uuid\Uuid;
use Sem\Weben\HttpException;

class ThreadService
{

  /**
   * @throws Exception
   */
  public static function createThread(string $name): Thread
  {
    try {
      $thread = new Thread();
      $uuid = Uuid::uuid4()->toString();
      $createdAt = time();
      $thread->setName($name);
      $thread->setUid($uuid);
      $thread->setCreatedat($createdAt);

      if ($thread->validate()) {
      // echo $uuid . " " . $name;
        $thread->save();
        return $thread;
      } else {
        throw new HttpException("thread already exists", 400);
      }

    } catch (HttpException $e) {
      throw $e;
    } catch (Exception $exception) {
      error_log($exception->getMessage());
      throw new Exception("could not create thread");
    }
  }

  public static function getThreads(): array
  {
    return ThreadQuery::create()->find()->toArray();
  }
}