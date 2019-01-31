<?php

header("Access-Control-Allow-Origin: http://localhost/rest-api-auth/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/Config.php';
include_once 'config/Common.php';
include_once 'model/Access.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Api\Config\Config;
use \Api\Config\Common;
use \Api\Model\Access;
 
// check email existence here
// get posted data
$data = json_decode(file_get_contents("php://input"));

#check fields
$required["username"]   = 1;
$required["password"]   = 1;  

Common::checkFields($required, $data);

// instantiate user object
$user = new Access();

// set user property values
$user->userName = $data->username;
 
// check if email exists and if password is correct
if($user->userExists() && password_verify($data->password, $user->password)){
 
    $token = array(
       "iss" => _ISS_,
       "aud" => _AUD_,
       "iat" => _IAT_,
       "nbf" => _NBF_,
       "data" => array(
           "id"         => $user->id,
           "username"   => $user->userName,
           "password"   => $user->password,

       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, _KEY_);

    $where["id"]     = $user->id;
    $update["token"] = $jwt;

    $user->update($where, $update);

    $out['message']   = 'Successful login.';
    $out['token']     = $jwt;

    Common::return_result($out);
}// login failed
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user login failed
    Common::return_error("Login failed");
}
?>