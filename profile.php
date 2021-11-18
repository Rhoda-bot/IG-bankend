<?php
  require_once("connect.php");
  require_once("header.php");
  $query = $database_obj->userInfos($email);
  echo json_encode($query);
?>