<?php

declare(strict_types=1);

ini_set('display_errors', 0);

require_once "../vendor/autoload.php";
require_once "../class_parse_array.php";

use \Firebase\JWT\JWT;



function main(): string
{

    $SECRET_KEY = getenv("JWT_PASS");
    $DEFAULT_ALG = getenv("JWT_ALG");
    
    $req_json = json_decode(file_get_contents(("php://input")), true);

    $username = $req_json["username"];
    $pass = $req_json["pass"];

    $db = new SQLite3("../database/user_info.db");
    $query = $db->prepare("SELECT password from users where username = :username");
    $query->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $query->execute();

    if ($result == false) {
        http_response_code(500);
        return "Internal server error";
    }

    $result_arr = $result->fetchArray(SQLITE3_ASSOC);

    if ($result_arr == false) {
        http_response_code(401);
        return '存在しないユーザー名です。';
    }

    if (!password_verify($pass, $result_arr["password"])) {
        http_response_code(401);
        return "パスワードが間違っています。";
    }

    $db->close();

    // 12 hours
    $token_expire = 60 * 60 * 60 * 12;

    $jwt_payload = [
        'exp' => (time() + $token_expire),
        'iss' => 'umipro_web'
    ];

    $token = JWT::encode($jwt_payload, $SECRET_KEY, $DEFAULT_ALG);



    $cookie_opt = [
        'secure' => getenv("exec_mode") != "DEV",
        'httponly' => true,
        'samesite' => 'strict',
        'expires' => time() + $token_expire,
        'path' => '/'
    ];

    setcookie('token', $token, $cookie_opt);

    return "OK";
}


echo main();