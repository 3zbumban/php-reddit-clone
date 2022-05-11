<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\HttpException;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\PostService;
use Sem\Weben\Service\UserService;

class PostController
{

  /**
   * @throws Exception
   */
  public function list(RequestInterface $req, ResponseInterface $res): void
  {
    $query = $req->getQueryParams();
    if (empty($query['threadId'])) {
      throw new Exception('Missing parameters');
    }
    $threadId = $query["threadId"];

    $posts = PostService::findPostsByThreadId($threadId);
    $res->setStatusCode(200);
    $res->setBody($posts);
  }

  /**
   * @throws HttpException
   */
  public function create(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth
    $body = $req->getBody();
    $header = $req->getHeader();

    if (empty($header['Access-Token']) || empty($body['userUid'])) {
      throw new HttpException('Unauthenticated', 401);
    }

    if (empty($body['title']) || empty($body['text']) || empty($body['userUid']) || empty($body['threadUid'])) {
      throw new HttpException('Missing parameters', 400);
    }


    $title = $body["title"];
    $text = $body["text"];
    $userUid = $body["userUid"];
    $threadUid = $body["threadUid"];
    $jwt = $header["Access-Token"];

    try {
      $user = UserService::checkJwtAndUser($jwt, $userUid);
    } catch (Exception $ex) {
      throw new HttpException($ex->getMessage(), 401);
    }

    try {
      $post = PostService::createPost($title, $text, $userUid, $threadUid);
    } catch (Exception $e) {
      throw new HttpException($e->getMessage(), 400);
    }

    $res->setStatusCode(200);
    $res->setBody([
        "post" => $post,
        "user" => $user
    ]);
  }

  /**
   * @throws Exception
   */
  public function get(RequestInterface $req, ResponseInterface $res): void
  {
    $pathParams = $req->getPathParams();
    if (empty($pathParams[2])) {
      throw new HttpException('Missing parameters', 400);
    }
    $postId = $req->getPathParams()[2];
    $post = PostService::findOneByUid($postId);

    $res->setStatusCode(200);
    $res->setBody($post);
  }
}