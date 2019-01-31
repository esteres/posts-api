<?php
namespace Api\Model;

use \PDO;
/*
* 2019 Esteban Restrepo Ramirez
*  @author Esteban Restrepo Ramirez <esteban.desarrollado@gmail.com>
*/


abstract class SqlDao {

	private $_server    = _DB_SERVER_;
	
	private $_driver 	= _DB_DRIVER_;
	
	private $_port      = _DB_PORT_;
    
    private $_database  = _DB_NAME_;		
	private $_user      = _DB_USER_;

	private $_password  = _DB_PASSWD_;

	
	private $_dbc;
	
	protected $table;

	protected $fields;
    
	public function __construct ($table){
		$this->table         = $table;
        
        #lets try to connect
		$this->connect();
	} 

	private function connect()
	{
		if ($this->_dbc == NULL) {
			$dsn = "" .
				$this->_driver .
				":host=" . $this->_server .
				";port=" . $this->_port .
				";dbname=" . $this->_database .
				";charset=utf8mb4";
			try {
				$this->_dbc = new PDO( $dsn, $this->_user, $this->_password, array(PDO::ATTR_PERSISTENT => true));
			} catch( PDOException $e ) {
				echo __LINE__.$e->getMessage();
			}
		}
	}
			
	public function __destruct()
	{
		$this->_dbc = NULL;
	}
	
	public function getRecords ($where_array=false, $count=false, $order_str=false, $start=0){
	   
        foreach((array)$where_array as $key => $value){
            $where_keys[] = "$key= :$key";
        }
        
		$where = $where_keys ? "WHERE ".join(" AND ",$where_keys) : "";
		$order = $order_str ? "ORDER BY $order_str" : "";
		$limit = $count ? "LIMIT $start, $count" : "";
        
		$query = "SELECT * FROM {$this->table} $where $order $limit";
		
        return $this->getQuery($query, $where_array);
	}
	
	public function create ($insert){

		$fields = array_keys($insert);
		$fieldsAsString =implode (', ', $fields);

		foreach ($fields as &$field) {
			$field = ':'.$field;
		}
		
		$query ="INSERT INTO {$this->table} ($fieldsAsString) VALUES (".join(', ', $fields).")";

		return $this->runQuery($query, $insert);
	}
    
    public function update ($where_array, $update){
		foreach ((array)$where_array as $key => $value) {
			$where_keys[] = "$key= :$key";
		}
        
        foreach ((array)$update as $key => $value) {
			$update_keys[] = "$key= :$key";
		}

		#return array("where"=>$where_keys, "update"=>$update_keys);

		$query = "UPDATE {$this->table} SET ".implode(",", $update_keys)." WHERE ".implode(",",$where_keys);
		
		return $this->runQuery($query, ($where_array + $update));
	}
    
	private function preparQuery($sql, $value_params, $types = false){
        $stmt = $this->_dbc->prepare( $sql );
		
        #else::
		foreach((array)$value_params as $key => &$value) {
			if($types) {
				$stmt->bindParam(":$key",$value);
			} else {
				if(is_int($value))        { $param = PDO::PARAM_INT; }
				elseif(is_bool($value))   { $param = PDO::PARAM_BOOL; }
				elseif(is_null($value))   { $param = PDO::PARAM_NULL; }
				elseif(is_string($value)) { $param = PDO::PARAM_STR; }
				else { $param = FALSE;}
                
				if($param) $stmt->bindParam(":$key",$value,$param);
			}
		}
		return $stmt;
	} 
    
	private function runQuery($sql, $value_params, $types=false) {
			
    	$stmt = $this->preparQuery($sql, $value_params, $types);
        
        if($stmt->execute()){
        	return true;
        }

    	return $stmt->errorInfo();
	}

	public function getQuery( $sql, $value_params, $types=false) {
		$stmt = $this->preparQuery($sql, $value_params, $types);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>