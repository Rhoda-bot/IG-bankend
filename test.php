<?php
 use CorsHelper\CorsHelper;
 use Firebase\JWT\JWT;
 require('vendor/autoload.php');
 $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
 $dotenv->load();
 $headers = getallheaders();
CorsHelper::GrantRequest();
$authorization = $headers['Authorization'];
$jwt = trim(explode(" ", $authorization)[1]);
$verifiedJWT= JWT::decode($jwt, $_ENV['JWTSECRET'], ["HS256"]);
$info = $verifiedJWT[0];
$id = $info->details->id;

// const reader = new FileReader()
//       reader.onload = (e) => {
//         const image = e.target.result
//         const formdata = { msg: this.message, image }
//         axios.post('http://localhost/backend/posts.php', formdata, {
//           headers: {
//             authorization: `Bearer ${localStorage.token}`
//           }
//         }).then(function (res) {
//           if (!res) {
//             console.log('unsuccessful')
//           } else {
//             console.log(res.data)
//           }
//         }).catch(e => console.log(e))
//       }
//       reader.readAsDataURL(this.file)
//     }
//   }
//// $img = $formdata['image'];
// $dir = getcwd();
// $imageN = $dir.'uploads/'.$img; 
// move_uploaded_file($img, 'uploads/'.$imageN);
// list($type, $img) = explode(';', $img);
// list(,$extension) = explode('/', $type);
// list(,$img) = explode(',', $img);
// $fileName = uniqid().'.'.$extension;
// $imageData = base64_decode($img);
// print_r($imageN);
// // print_r(file_put_contents($fileName, $imageData));