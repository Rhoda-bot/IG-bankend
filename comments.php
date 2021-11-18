<?php
require_once("connect.php");
require_once("header.php");
$comment = $formdata['comment'];
$postId = $formdata['postId'];
$query = $database_obj->makeComment($comment,$postId,$id);
echo json_encode($query);
?>