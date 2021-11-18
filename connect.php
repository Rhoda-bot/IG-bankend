<?php
 require ('vendor/autoload.php');
 require_once('database.php');
 $secret = "whatthehectdoyouneedasecretfor";
 use Firebase\JWT\JWT;
 use CorsHelper\CorsHelper;
 CorsHelper::GrantRequest(['origin'=>['http://localhost:8081']]);
 $database_obj = new Database(); 
 $formdata = json_decode(file_get_contents('php://input'), true);
?>