<?php

header("Access-Control-Allow-Origin: http://localhost/posts-api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

include_once 'config/Config.php';
include_once 'config/Common.php';
include_once 'model/Post.php';

use \Api\Config\Config;
use \Api\Config\Common;
use \Api\Model\Post;

// get posted data
$data = json_decode(file_get_contents("php://input"));



#check fields
$required["title"]    = 1;
$required["author"]   = 1;	
$required["content"]  = 1; 
$required["token"]	  = 1;

Common::checkFields($required, $data);

#validate access to the api
Common::validToken($data->token);


#lets check if we actually received an id
if(!is_int($data->author)){
	Common::return_error("Invalid author id");
}

// instantiate post object
$post = new Post();

// set post property values
$post->title 	= $data->title;
$post->author 	= $data->author;
$post->content 	= htmlentities(htmlspecialchars($data->content));
 
// create the post
if(!$post->create()){
 	
 	// set response code
    http_response_code(400);
 
 	Common::return_error("Unable to create the post");
}

#else:: it means the post was created 
// set response code
http_response_code(200);

// display message: post was created
$out['message']  = 'The post was created';
Common::return_result($out);
?>