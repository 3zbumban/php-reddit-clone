<?php

namespace Sem\Weben;

class Post {
  public string $title;
  public string $author;
  public string $text;

  function __construct(string $title, string $author, string $text) {
    $this->title = $title;
    $this->author = $author;
    $this->text = $text;
  }
}

class Reddit {
  private array $posts;

  function __construct() {
    $this->posts = [
      new Post("title1", "author", "text"),
      new Post("title2", "author", "text"),
      new Post("title3", "author", "text"),
      new Post("title4", "author", "text"),
      new Post("title5", "author", "text"),
      new Post("title6", "author", "text"),
    ];
  }

  function getPosts() {
    return $this->posts;
  }
}