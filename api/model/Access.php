<?php 

namespace Api\Model;

include_once 'SqlDao.php';
use \Api\Model\SqlDao;

class Access extends SqlDAO{
 
    // object properties
    public  $id;
    public  $userName;
    public  $password;
 
    // constructor
    public function __construct($table=null){
        #lets to know what table is belong to thi class
		parent::__construct ("access");
    }
 
    // create new user record
    public function create($insert=array()){
        $insert["username"]     = $this->userName;
        $insert["password"]     = $this->password;

        return parent::create($insert);
    }

    public function userExists(){
        $where["username"]  = $this->userName;
        $response = parent::getRecords($where, 1);

        if(!$response)  return false;
        #else:: it means we got something, now we just have to get the id

        $response = $response[0];
        $this->id = $response['id'];
        $this->userName = $response['username'];
        $this->password = $response['password'];

        return true;
    }
}

?>
