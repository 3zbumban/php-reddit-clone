<?php

namespace Sem\Weben\Service;

use Model\Thread;
use Model\ThreadQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Ramsey\Uuid\Uuid;


class ThreadService
{

  public static function createThread(string $name)
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
      } catch (\Exception $exception) {
        throw new \Exception("could not create thread");
      }
    } else {
      throw new \Exception("thread already exists");
    }

  }

  public static function getThreads(): ObjectCollection
  {
    return ThreadQuery::create()->find();
  }
}