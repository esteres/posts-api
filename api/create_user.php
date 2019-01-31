<?php

// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-auth/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once 'config/Config.php';
include_once 'config/Common.php';
include_once 'model/Access.php';
 
use \Api\Config\Config;
use \Api\Config\Common;
use \Api\Model\Access;

// get posted data
$data = json_decode(file_get_contents("php://input"));

#check fields
$required["username"]   = 1;
$required["password"]   = 1;	

Common::checkFields($required, $data);

// instantiate user object
$user = new Access();
 
// set product property values
$user->userName = $data->username;
$user->password = password_hash($data->password, PASSWORD_BCRYPT);
 
// create the user

// create the user
if(!$user->create()){
 	
 	// set response code
    http_response_code(400);
 
 	Common::return_error("Unable to create the user");
}

#else:: it means the user was created 
// set response code
http_response_code(200);

// display message: user was created
$out['message']  = 'The user was created';
Common::return_result($out);
?>