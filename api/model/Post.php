<?php 

namespace Api\Model;

include_once 'SqlDao.php';
use \Api\Model\SqlDao;

class Post extends SqlDAO{
 
    // object properties
    private $id;
    public  $title;
    public  $author;
    public  $content;
    public  $dateCreated;
    public  $dateUpdated;
 
    // constructor
    public function __construct($table=null){
        #lets to know what table is belong to thi class
		parent::__construct ("post");
    }
 
    // create new user record
    public function create($insert=array()){
        $insert["title"]        = $this->title;
        $insert["author"]       = $this->author;
        $insert["content"]      = $this->content;
        $insert["date_created"] = time();

        return parent::create($insert);
    }
}

?>