<?php
require_once("connect.php");
require_once("header.php");
#follower is the person i'm wanting to follow
$follower = $formdata['index'];
$status = $formdata['status'];
$query = $database_obj->insertFollowers($id,$follower,$status);
// print_r(gettype($follower));
echo json_encode($query);
// print_r($query);