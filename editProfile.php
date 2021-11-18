<?php
require_once("connect.php");
require_once("header.php");
$newemail = $formdata['email'];
$fullname = $formdata['fullname'];
$username = $formdata['username'];
$phone = $formdata['phone'];
$bio = $formdata['bio'];
$query = $database_obj->updateProfile($newemail,$fullname,$username,$phone,$bio,$id);
print_r($query);
?>