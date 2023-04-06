<?php
declare(strict_types=1);

require_once "../vendor/autoload.php";
require_once "../class_parse_array.php";

use \Firebase\JWT\JWT;

const SECRET_KEY = getenv("JWT_PASS");
const DEFAULT_ALG = getenv("JWT_ALG");

function main(): string {

$req_json = json_decode(file_get_contents(("php://input")), true);

$username = $req_json["username"];
$email = $req_json["email"];
$pass = $req_json["pass"];

$isValid = (preg_match('/^[^\x20-\x7e]{1,20}$/', $username) || preg_match('/^\w{1,20}$/', $username)) && preg_match('/^\w+(\+\w+)?@\w+\.\w+$/', $email) && preg_match('/^(\w){5,20}$/', $pass);

if (!$isValid) {
    http_response_code(400);
    return "Bad Request";
}

$db = new SQLite3("../database/user_info.db");
$hash_pass = password_hash($pass, PASSWORD_DEFAULT);
$query = $db->prepare("INSERT INTO users (username, email, password, created_at, updated_at) VALUES (:username, :email, :pass, datetime('now', 'localtime'), datetime('now', 'localtime'))");
$query->bindValue(':username', $username, SQLITE3_TEXT);
$query->bindValue(':email', $email, SQLITE3_TEXT);
$query->bindValue(':pass', $hash_pass, SQLITE3_TEXT);
$result = $query->execute();
if($result == false) {
    http_response_code(500);
    return "Internal Server Error";
}

$db->close();

// 12 hours
$token_expire = 60 * 60 * 60 * 12;

$jwt_payload = [
    'exp' => (time() + $token_expire),
    'iss' => 'umipro_web'
];

$token = JWT::encode($jwt_payload, SECRET_KEY, DEFAULT_ALG);



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