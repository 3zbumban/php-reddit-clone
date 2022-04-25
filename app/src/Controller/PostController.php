<?php

namespace Sem\Weben\Controller;

use Model\PostQuery;
use Ramsey\Uuid\Uuid;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\PostService;

class PostController
{

  public function list(RequestInterface $req, ResponseInterface $res): void
  {
    $query = $req->getQueryParams();
    $threadId = $query["threadId"];

    $posts = PostService::findPostsByThreadId($threadId);
    $res->setStatusCode(200);
    $res->setBody($posts);
    $res->json();
  }

  public function create(RequestInterface $req, ResponseInterface $res)
  {
    $body = $req->getBody();
    $title = $body["title"];
    $text = $body["text"];
    $userUid = $body["userUid"];
    $threadUid = $body["threadUid"];

    $post = PostService::createPost($title, $text, $userUid, $threadUid);

    $res->setStatusCode(200);
    $res->setBody($post);
    $res->json();
  }

  public function get(RequestInterface $req, ResponseInterface $res) {
    $postId = $req->getPathParams()[2];
    $post = PostService::findOneByUid($postId);

    $res->setStatusCode(200);
    $res->setBody($post);
    $res->json();
  }
}