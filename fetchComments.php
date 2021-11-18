<?php
require_once("connect.php");
require_once("header.php");
$postId = $formdata['postId'];
$query = $database_obj->fetchComments($postId);
echo json_encode($query);