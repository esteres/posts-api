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
$data = $_GET;

#check fields 
$required["token"]	  	= 1;

Common::checkFields($required, $data);

#validate access to the api
Common::validToken($data["token"]);



// instantiate post object
$post = new Post();


$posts = $post->getRecords();

if(!$posts){
	// set response code
    http_response_code(404);
 
 	Common::return_error("No posts found");
}

#else:: it means we got something

foreach((array)$posts as $key => &$value){
	$value["content"] = html_entity_decode(htmlspecialchars_decode($value["content"]));
}

//Common::return_result(Common::arrayToTable($posts));
Common::return_result($posts);
?>