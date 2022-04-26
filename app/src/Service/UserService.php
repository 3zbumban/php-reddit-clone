<?php

namespace Sem\Weben\Service;

use Exception;
use Model\User;
use Model\UserQuery;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserService
{

  private static function jwtSign(string $username, int $userId): string
  {
    $jwt_secret = $_ENV["JWT_SECRET"];
    $payload = [
        "username" => $username,
        "userId" => $userId,
        "iat" => time(),
    ];
    return JWT::encode($payload, $jwt_secret, "HS256");
  }

  /**
   * @throws Exception
   */
  public static function createUser(string $username, string $password): array
  {
    $user = new User();
    $passwordHash = password_hash($password, PASSWORD_ARGON2I);
    $user->setUsername($username);
    $user->setPassword($passwordHash);

    if (!$user->validate()) {
      throw new Exception("Invalid user");
    } else {
      try {
        $user->save();
        return [
            "username" => $user->getUsername(),
            "userId" => $user->getId(),
            "jwt" => self::jwtSign($user->getUsername(), $user->getId())
        ];
      } catch (Exception $exception) {
        throw new Exception("could not save or sign user");
      }
    }
  }

  /**
   * @throws Exception
   */
  public static function signin(string $username, string $password): array
  {
    $user = UserQuery::create()->findOneByUsername($username);
    if ($user !== NULL) {
      $valid = password_verify($password, $user->getPassword());
      if ($valid) {
        return [
            "username" => $user->getUsername(),
            "userId" => $user->getId(),
            "jwt" => self::jwtSign($user->getUsername(), $user->getId())
        ];
      } else {
        throw new Exception("password incorrect");
      }
    } else {
      throw new Exception("user not found");
    }
  }

  /**
   * @throws Exception
   */
  public static function checkJwtAndUser(string $jwt, int $userId): array
  {
    $user = UserQuery::create()->findOneById($userId);
    if (!$user) throw new Exception("user not found");
    $jwt_secret = $_ENV["JWT_SECRET"];
    try {
      $decoded = JWT::decode($jwt, new Key($jwt_secret, 'HS256'));
      $usernameFromJwt = $decoded->username;
      $userIdFromJwt = $decoded->userId;
      $iat = $decoded->iat;
      $valid = $usernameFromJwt === $user->getUsername() && $userIdFromJwt === $user->getId() && $iat > time() - 3600;
      if ($valid) {
        return [
          "username" => $user->getUsername(),
          "userId" => $user->getId(),
          "jwt" => self::jwtSign($user->getUsername(), $user->getId())
        ];
      } else {
        throw new Exception("invalid jwt");
      }
    } catch (Exception $exception) {
      throw new Exception("invalid jwt");
    }
  }
}