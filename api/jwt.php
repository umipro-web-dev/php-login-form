<?php

declare(strict_types=1);

require_once "../vendor/autoload.php";
require_once "../class_parse_array.php";

use \Firebase\JWT\JWT;

//デコードの時に使う。
use \Firebase\JWT\KEY;

$jwt_body = json_decode(file_get_contents('php://input'), true);

$key = "abcdefg";

$alg = "HS256";

$encoded = JWT::encode($jwt_body, $key, $alg);

echo $encoded;

echo "\n";

$decoded = JWT::decode($encoded, new KEY($key, $alg));

$decoded = class_parse_array($decoded);

print_r($decoded);
