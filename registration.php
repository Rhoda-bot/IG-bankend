<?php 
  require_once("connect.php");
  $email = $formdata['email'];
  $fullname = $formdata['fullname'];
  $username = $formdata['user'];
  $phone = $formdata['phone'];
  $password = $formdata['pass'];
  $validate_pass = password_hash($password, PASSWORD_DEFAULT);
   $query = $database_obj->insertFunc($email,$fullname,$username,$phone,$validate_pass);
  print_r($query);
?>