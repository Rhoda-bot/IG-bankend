<?php
require_once("connect.php");
require_once("header.php");
$post_id = $formdata['ind'];
$query = $database_obj->deletePost($post_id);
print_r($query);