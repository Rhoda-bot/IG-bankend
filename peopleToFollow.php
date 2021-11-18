<?php
require_once("connect.php");
require_once("header.php");
$query = $database_obj->peopleToFollow($id);
echo json_encode($query);
?>