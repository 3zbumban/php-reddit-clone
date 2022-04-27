<?php

namespace Sem\Weben\Service;

use Exception;
use Model\Thread;
use Model\ThreadQuery;
use Ramsey\Uuid\Uuid;


class ThreadService
{

  /**
   * @throws Exception
   */
  public static function createThread(string $name): Thread
  {
    $thread = new Thread();
    $uuid = Uuid::uuid4()->toString();
    $createdAt = time();
    $thread->setName($name);
    $thread->setUid($uuid);
    $thread->setCreatedat($createdAt);

    if ($thread->validate()) {
      // echo $uuid . " " . $name;
      try {
        $thread->save();
        return $thread;
      } catch (Exception $exception) {
        throw new Exception("could not create thread");
      }
    } else {
      throw new Exception("thread already exists");
    }
  }

  public static function getThreads(): array
  {
    return ThreadQuery::create()->find()->toArray();
  }
}