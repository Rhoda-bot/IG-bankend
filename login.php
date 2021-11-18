<?php
require_once("connect.php");
$email = $formdata['email'];
$query = $database_obj->selectLoggedUser($email);
print_r($query);
?>