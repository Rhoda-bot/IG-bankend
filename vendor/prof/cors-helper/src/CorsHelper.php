<?php
namespace CorsHelper;
class CorsHelper{
  public static function GrantRequest($data=[])
  {
    $myInfo=(new CorsHelper)->ifEmpty();
    $myHeaders = getallheaders();
    if(isset($_SERVER['HTTP_ORIGIN']) && isset($_SERVER['REQUEST_METHOD']) && isset($myHeaders)){
        
      if(!empty($data['origin'])){
        $origin = (new CorsHelper)->handleOrigin($data['origin']);
        $myInfo['origin'] = $origin;
      }
      if(!empty($data['maxAge'])){
        $maxAge =(new CorsHelper)->handleMaxAge($data['maxAge']); 
        $myInfo['maxAge'] = $maxAge;
      }
       if(!empty($data['header'])){
        $header =(new CorsHelper)->handleHeaders($data['header']); 
        $myInfo['header'] = $header; 
      }
       if(!empty($data['method'])){
        $method =(new CorsHelper)->handleMethods($data['method']);
        $myInfo['method'] = $method;
      }
       if(!empty($data['contentType'])){
         $contentType =(new CorsHelper)->handleContentType($data['contentType']);
        $myInfo['contentType'] = $data['contentType'];
      }
      if(!empty($data['credentials'])){
        $credentials =(new CorsHelper)->handleCredential($data['credentials']);
        $myInfo['credentials'] = $data['credentials'];
      }
    }
  
    (new CorsHelper)->setAccess($myInfo['origin'], $myInfo['method'], $myInfo['header'], $myInfo['contentType'],$myInfo['credentials'],$myInfo['maxAge']);
  }
  //SET UP THE CORS VALUE
  public function setAccess($url,$method,$header,$contentType,$credentials,$maxAge){
    if(isset($_SERVER['HTTP_ORIGIN']) && isset($_SERVER['REQUEST_METHOD']) ){
      header("Access-Control-Allow-Origin: $url");
      header("Access-Control-Allow-Methods: $method");
      header("Access-Control-Allow-Headers: $header");
      header("Content-Type: $contentType");
      header("Access-Control-Allow-Credentials: $credentials");
      header("Access-Control-Max-Age: $maxAge");
    }
  } 
 //DEFAULT SETUP
   public function ifEmpty(){
    $url=  '*';
    $method = 'POST,GET,DELETE,PUT,PATCH,OPTIONS';
    $credentials = true;
    $maxAge =72800;
    $header = 'X-Requested-With,token,Authorization,X-Auth-Token,Origin,Content-Type,Cache-Control, Pragma,Accept, Accept-Encoding';
    $contentType= 'text/plain';
    return(['origin'=>$url, 'method'=>$method,'header'=>$header,'contentType'=>$contentType,'credentials'=> $credentials, 'maxAge'=>$maxAge]);
}
//HANDLE ORIGIN
public function handleOrigin($origin){
  if(isset($_SERVER['HTTP_ORIGIN'])){
    $currentOrigin = $_SERVER['HTTP_ORIGIN'];
    if(gettype($origin)=='string' && $currentOrigin == $origin) return $origin;
    elseif (gettype($origin)=='array'){
      $index = array_search($currentOrigin, $origin);
        return $origin[$index];
    } 
  }
}
  //HANDLE HEADER
  public function handleHeaders($header){
    $allHeaders = ['X-Requested-With','token','Authorization','X-Auth-Token','Origin','Content-Type','Cache-Control','Pragma','Accept','Accept-Encoding'];
    $response = "";
    if(gettype($header)=='string'){
      array_push($allHeaders,$header);
      $response = array_unique($allHeaders);
    }elseif(gettype($header)=='array') $response = array_unique(array_merge($allHeaders,$header));
    return implode(', ', $response);
  }
  //HANDLE METHOD
  public function handleMethods($method){
    $currentMethod = $_SERVER['REQUEST_METHOD'];
    $response = "";
    $allMethod = ['POST','GET','DELETE','PUT','PATCH','OPTIONS'];
    if(gettype($method)=='string' && in_array($method,$allMethod)){
      if($currentMethod == $method) $response = $method;
      else throw new \Exception('Request does not allow');
    }
    if(gettype($method)=='array' && !empty(array_intersect($allMethod,$method))){
       $index = array_search($currentMethod, $method);
       if($index > -1) $response = implode(', ', $method);
       else  throw new \Exception('Request does not allow');   
    }
    return $response;
  }
  //HANDLE CONTENT-TYPE
  public function handleContentType($contentType){
    $response = "";
    if(gettype($contentType)=='string')  $response = $contentType;
    return $response;
  }
  //HANDLE CREDENTIAL
  public function handleCredential($credentials){
    $response = "";
    if(gettype($credentials)=='string'){
      $response = filter_var($credentials,FILTER_VALIDATE_BOOLEAN);
    }elseif(gettype($credentials)=='boolean') $response = $credentials;
    return $response;
  }
  //HANDLE MAX-AGE
  public function handleMaxAge($age){
    $response = "";
    if(gettype($age)=='string') $response = intval($age);
    elseif(gettype($age)=='array')   $response = intval($age[0]);
    else $response = $age;
    return $response;
  }
}
?>