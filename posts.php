<?php
require_once("connect.php");
require_once("header.php");
// use Firebase\JWT\JWT;
// $secret = "whatthehectdoyouneedasecretfor";
// $headers = getallheaders();
// $authorization = $headers['authorization'];
// $jwt = trim(explode(" ", $authorization)[1]);
// $verifiedJWT= JWT::decode($jwt, $secret, ["HS256"]);
// $info = $verifiedJWT[0];
// $user = $info->aud;
// $email = $user['0'];
// $id = $user['1'];
$img = $_FILES['file']['name'];
$imgSize = $_FILES['file']['size'];
$rand = time();
$imageFileType = strtolower(pathinfo($img,PATHINFO_EXTENSION));
$allow_extensions = array('jpg','jpeg','png','gif');
$fileName = $rand.".".$imageFileType;
if ($imgSize > 500000) {
 echo "greater". $imgSize;
}else {
  if (in_array($imageFileType,$allow_extensions)) {
    $image = move_uploaded_file($_FILES['file']['tmp_name'],'uploads/'.$fileName);
   if ($image) {
     $query =  $database_obj->makePost($fileName,$id);
      echo json_encode($query);
   }else {
     echo 0;
   }
  }else {
    echo 0;
  }
}
// print_r($headers['Content-Type']);

?>