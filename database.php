<?php 
use Firebase\JWT\JWT;
  class Database 
  {
    // private $name = "Rhoda";
    private $localhost = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "instagram_db";
    public function __Construct()
    {
      $conn = new mysqli($this->localhost,$this->username,$this->password,$this->database);
      $this->conn = $conn;
      if (mysqli_error($conn)) {
        die();
      }
    }

  public function insertFunc($email,$fullname,$username,$phone,$password)
    {
      $insert_query = "INSERT INTO registration_tb(email, fullname,username,phone, password) VALUES (?,?,?,?,?)";
      $data = $this->conn->prepare($insert_query);
      $data->bind_param("sssss",$email,$fullname,$username,$phone,$password);
      if($data->execute()){
        echo "data added successfully";
      }else{
        echo "data added unsuccessfully";
        print_r($data); 

      };
 
    }
    public function selectLoggedUser($email)
    {
      $select_query = "SELECT `reg_id`, `email`, `fullname`, `username`, `phone`FROM `registration_tb` WHERE email = ?";
      $data = $this->conn->prepare($select_query);
      $data->bind_param("s",$email);
      $data->execute();
      $result = $data->get_result();
      if ($result) {
       $result = $result->fetch_assoc();
       $id = $result['reg_id'];
        $secret = "whatthehectdoyouneedasecretfor";
        $payload = array(["iss" => "localhost",
          "details" => [
            $email,
            $id
          ],
          "iat" => time(),
          "nbf" => time()*3600
      ]);
      $jwt = JWT:: encode($payload,$secret);
       print_r($jwt);
      }else {
        print_r($result)."please............";
      }
    }
    public function userInfos($email)
    {
      $select_query = "SELECT reg_id, email, fullname, username, phone, bio, image FROM `registration_tb` WHERE email = ?";
      $data = $this->conn->prepare($select_query);
      $data->bind_param("s",$email);
      $data->execute();
      $result = $data->get_result();
      if ($result) {
        return $result->fetch_assoc();
      }else {
       print_r($data);
      }
      
    }
    public function updateProfile($email,$fullname, $username, $phone, $bio, $id)
    {
      $update_query = "UPDATE `registration_tb` SET `email`=?,`fullname`=?,`username`=?,`phone`=?,`bio`=? WHERE reg_id = '$id'";
      $data = $this->conn->prepare($update_query);
      $data->bind_param("sssss",$email,$fullname,$username,$phone,$bio);
      $data->execute();
      if (( $result = $data->get_result()) ) {
       return $result->fetch_all();
     
      }else {
      return $result;
      }
    }
    public function makePost($post_body,$user)
    {
      $insert_query = "INSERT INTO `post_tb`( `post_body`, `reg_id`) VALUES (?,?)";
      $data = $this->conn->prepare($insert_query);
      $data->bind_param("si",$post_body,$user);
      $data->execute();
     
      if (($data = $data->get_result())) {
       return $data;
      }else {
        return $data;
      }
    }
    public function fetchPost($user)
    {
    //  $select_query = "SELECT f.following,r.username,p.post_body,p.post_id FROM `follow_tb`f JOIN `registration_tb`r JOIN `post_tb`p WHERE f.following =?";
    //  $select_query = "SELECT `post_body` FROM `post_tb` WHERE `reg_id` = ?";
    // SELECT r.username, p.post_body, r.reg_id FROM `registration_tb`r JOIN `post_tb` p WHERE r.reg_id =33
    //  $select_query = "SELECT r.username, p.post_body, r.reg_id FROM `registration_tb`r JOIN `post_tb` p WHERE r.reg_id = ?";
    $select_query = "SELECT p.post_body, r.username FROM `post_tb`p JOIN `registration_tb`r ON(r.reg_id =?)";
     $data = $this->conn->prepare($select_query);
     $data->bind_param('i',$user);
     $data->execute();
     if (($data = $data->get_result())) {
      return $data->fetch_all(MYSQLI_ASSOC);
     }else {
       return $data;
     }
    }
    public function peopleToFollow($user)
    {
      $select_query = "SELECT `reg_id`, `fullname`, `username` FROM `registration_tb` WHERE reg_id != ?";
      $data = $this->conn->prepare($select_query);
      $data->bind_param('i',$user);
      $data->execute();
      if (($data = $data->get_result())) {
       return $data->fetch_all(MYSQLI_ASSOC);
      }else {
        return $data;
      }
    }
    public function insertFollowers($id,$follower_id,$status)
    {
      $select_query = "SELECT `following`, `follower`, `status` FROM `follow_tb` WHERE follower = $follower_id";
      $checkQuery = $this->conn->query($select_query);
      if ($checkQuery->num_rows > 0) {
        return "user already exist";
      }else{
        $insert_query = "INSERT INTO `follow_tb`( `following`, `follower`, `status`) VALUES (?,?,?)";
        $data = $this->conn->prepare($insert_query);
        $data->bind_param('iib',  $id,$follower_id,$status);
        $data->execute();
        if (($data = $data->get_result())) {
          return "data successfully added";
        }else {
          return $data;
        }
      }
   }
   public function makeComment($comment,$post_id,$user_id)
   {
     $insert_query = "INSERT INTO `comment_tb`(`comment`, `post_id`, `reg_id`) VALUES (?,?,?)";
     $data = $this->conn->prepare($insert_query);
     $data->bind_param("sii",$comment,$post_id,$user_id);
     $data->execute();
     if (($data = $data->get_result())) {
      return $data;
     }else {
       return $data;
     }
   }
   public function fetchComments($post_id)
   {
     $select_query = "SELECT c.comment,r.username FROM `comment_tb` c JOIN `post_tb`p ON(p.post_id = c.post_id) JOIN `registration_tb` r ON (r.reg_id = p.reg_id) WHERE c.post_id = ?";
     $data = $this->conn->prepare($select_query);
     $data->bind_param('i',$post_id);
     $data->execute();
     if (($data = $data->get_result())) {
      return $data->fetch_all(MYSQLI_ASSOC);
     }else {
      return $data;
     }
   }
   public function deletePost($post_id)
   {
    $delete_query = "DELETE FROM `post_tb` WHERE post_id = ?";
    $data = $this->conn->prepare($delete_query);
    $data->bind_param('i',$post_id);
    $data->execute();
    if (($data = $data->get_result())) {
      return "data successfully deleted";
    }else {
      return "data successfully deleted";
      return $data;
    }
   }
  }
 
  
?>