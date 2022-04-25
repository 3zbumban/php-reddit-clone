<?php

namespace Sem\Weben\Service;

use Model\User;
use Model\UserQuery;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserService
{

  private static function jwtSign(string $username)
  {
    $jwt_secret = $_ENV["JWT_SECRET"];
    $payload = [
        "username" => $username
    ];
    return JWT::encode($payload, $jwt_secret, "HS256");
  }

  public static function createUser(string $username, string $password): array
  {
    $user = new User();
    $passwordHash = password_hash($password, PASSWORD_ARGON2I);
    $user->setUsername($username);
    $user->setPassword($passwordHash);
    if (!$user->validate()) {
      throw new \Exception("Invalid user");
    } else {
      try {
        $user->save();
        return [
            "username" => $user->getUsername(),
            "jwt" => self::jwtSign($user->getUsername())
        ];
      } catch (\Exception $exception) {
        throw new \Exception("could not save or sign user");
      }
    }
  }

  public static function signin(string $username, string $password): array
  {
    $user = UserQuery::create()->findOneByUsername($username);
    if ($user !== NULL) {
      $valid = password_verify($password, $user->getPassword());
      if ($valid) {
          return [
            "username" => $user->getUsername(),
            "jwt" => self::jwtSign($user->getUsername())
          ];
      } else {
        throw new \Exception("password incorrect");
      }
    } else {
      throw new \Exception("user not found");
    }
  }
}