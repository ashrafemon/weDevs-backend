<?php


namespace app\Core;


use app\Models\User;
use Firebase\JWT\JWT;

class Auth
{
    private static string $key = '!!p@asswordDiboNa??';
    private static array $user = [];

    public static function attemps($email, $password)
    {
        $user = (new User())->findByEmail($email);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                self::$user = $user;
                return true;
            }
        } else {
            return false;
        }
    }

    public static function user()
    {
        if (count(self::$user)) {
            return self::$user;
        } else {
            return null;
        }
    }

    public static function createToken()
    {
        if (count(self::$user)) {
            $iat = time();
            $exp = time() + 60 * 60;
            $payload = array("name" => self::$user['name'], "email" => self::$user['email'], "iat" => $iat, "exp" => $exp);
            return JWT::encode($payload, self::$key);
        } else {
            return '';
        }
    }

    public static function verifyToken()
    {
        $header = getallheaders();
        if (isset($header['Authorization'])) {
            try {
                $authToken = str_replace('Bearer ', '', $header['Authorization']);
                $data = (array)JWT::decode($authToken, self::$key, array('HS256'));
                self::$user = (new User())->findByEmail($data['email']);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }
}