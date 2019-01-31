<?php
/*
*  @author Esteban Restrepo Ramirez <esteban.desarrollador@gmail.com>
*/

namespace Api\Config;

require '../vendor/autoload.php';
include_once 'model/Access.php';

use \Firebase\JWT\JWT;
use \Api\Model\Access;

class Common
{
	
	#Validate access to the API
	public static function validToken($token)
    {
        try {
	        // decode jwt
	        $decoded = JWT::decode($token, _KEY_, array('HS256'));
	 		
	 		$where["token"] = $token;
	 		$user = new Access();
	 		$response = $user->getRecords($where, 1)[0];

	 		if(!$response){
	 			#it means the user logged out at some point
 				self::return_error("Access denied");
	 		} 
	 		
	 		#it means the user has access
	        return $response;
	 
	    }catch (Exception $e){
	 		http_response_code(400);
 	
			self::return_error("Access denied");
		}
    }

    public static function checkFields($required, $data)
    {
    	foreach ((array)$data as $key => $value) {

    		if($required[$key] && $value != "") continue;

    		#else:: it means there is a required param missing
    		http_response_code(422);
 
    		self::return_error("$key is missing");
    	}
    }
    
    # returns a json encoded error
    public static function return_error($errorMessage,$array=""){
    
        $out['result']  = 'fail';
        $out['error']   = $errorMessage;
        $out['payload'] = $array;
        echo json_encode($out);
    	exit;
    }
    
    # sucess output
    public static function return_result($array){
        $out['result']  = 'ok';
        $out['payload'] = $array;
        $j = json_encode($out);
        echo $j;
    }


    public static function arrayToTable($a) {
        if (!$a)
            return;
        
        foreach($a as $k => $v){
            foreach ($v as $sk => $sv) {
                $keymap[$sk] = $sk;
            }
        }
        
        $o="";
        # building the header based on the keys
        $o .= "<thead><tr>\n";
        
        # if position is required
       
        # loop trough all keys
        foreach($keymap as $k=>$v){
            $o .= "<th><div>$v</div></th>\n";
        }
        # close the header
        $o .= "</tr></thead>\n\n";
        
        
        # loop trough all entries and insert the data line
        foreach ($a as $k => $v) {

           
            $o .= "<tr class='dataline'>\n";
            
            
            
            foreach ($keymap as $kmv) {
                $sv = $v[$kmv];
                if (is_array($sv)) {
                    $sv = array_to_table($sv, $l = 1);
                }
                $o .= "<td><div>$sv</div></td>\n";
            }
            $new = 0;
            $o .= "</tr>\n\n";
        }
        $o = "<table class='default_table'>$o</table>";

        $o .= "
            <style>
                table{border-collapse: collapse;}
                .default_table{width:100%}
                .default_table td{vertical-align:middle;padding:2px;border-bottom:1px dotted #CCC;font-size:13px}
                .default_table tr.dataline:hover{background:#EEE}
                .default_table th{vertical-align:middle;border-bottom:1px solid #CCC;text-align:left;}
            </style>";
        return $o;

    }
}
