<?php
require_once("connect.php");
use Firebase\JWT\JWT;
$secret = "whatthehectdoyouneedasecretfor";
$headers = getallheaders();
$authorization = $headers['authorization'];
$jwt = trim(explode(" ", $authorization)[0]);
$verifiedJWT= JWT::decode($jwt, $secret, ["HS256"]);
$info = $verifiedJWT[0];
$user = $info->details;
$email = $user['0'];
$id = json_encode($user[1]);
