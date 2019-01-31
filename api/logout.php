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
$required["token"]   = 1; 

Common::checkFields($required, $data);

#validate access to the api
$userFound = Common::validToken($data->token);

// instantiate user object
$user = new Access();


$where["id"]     = $userFound["id"];
$update["token"] = "";

$user->update($where, $update);

$out['message']   = $userFound;

Common::return_result($out);
?>