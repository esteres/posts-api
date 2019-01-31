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

// get posted data
$data = $_GET;



#check fields 
$required["token"]	  	= 1;

Common::checkFields($required, $data);

#validate access to the api
Common::validToken($data["token"]);



// instantiate post object
$author = new Author();


$authors = $author->getRecords();

if(!$authors){
	// set response code
    http_response_code(404);
 
 	Common::return_error("No authors found");
}

#else:: it means we got something

Common::return_result($authors);
?>