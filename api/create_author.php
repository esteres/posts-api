<?php

header("Access-Control-Allow-Origin: http://localhost/posts-api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

include_once 'config/Config.php';
include_once 'config/Common.php';
include_once 'model/Author.php';

use \Api\Config\Config;
use \Api\Config\Common;
use \Api\Model\Author;

// instantiate author object
$author = new Author("author");

// get posted data
$data = json_decode(file_get_contents("php://input"));

#check fields
$required["firstName"]  = 1;
$required["lastName"]   = 1;	
$required["token"]   	= 1;

#check fields
checkFields($required, $data);

#validate access to the api
validToken($data->token);

// set author property values
$author->firstName = $data->firstName;
$author->lastName  = $data->lastName;
 
// create the author
if(!$author->create()){
 
    // set response code
    http_response_code(400);
 
    // display message: author was created
    Common::return_error("Unable to create the author");
}

#else:: it means the author was created 

// set response code
http_response_code(200);

// display message: post was created
$out['message']  = 'The author was created';
Common::return_result($out);
?>