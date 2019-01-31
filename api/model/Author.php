<?php 

namespace Api\Model;

include_once 'SqlDao.php';
use \Api\Model\SqlDao;

class Author extends SqlDAO{
 
    // object properties
    private $id;
    public  $firstName;
    public  $lastName;
    public  $dateCreated;
    public  $dateUpdated;
 
    // constructor
    public function __construct($table=null){
        #lets to know what table is belong to thi class
		parent::__construct ();
    }
 
    // create new user record
    public function create($insert=array()){
        $insert["first_name"]   = $this->firstName;
        $insert["last_name"]    = $this->lastName;
        $insert["date_created"] = time();

        return parent::create($insert);
    }
}

?>