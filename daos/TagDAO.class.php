<?php
 require_once __DIR__.'/../models/Tag.class.php';
 require_once __DIR__.'/../utils/MySQLiAccess.class.php';
 require_once __DIR__.'/../utils/ModelFactory.class.php';

 
 Class TagDAO {
	 
	 
	public static function getTags($TaskId){
		 
		$tag = null;
		 
		if(!is_null($TaskId)){
			
			/*Creates args to pass to the MySQLiAccess class's call method, thereby using an SQL statment
			to retrieve the desired tags from the database*/
			$args = $TaskId;
			$ret = null;
			//The results from the database, after being retrieved by the MySQLiAccess call method, are stored in the variable '$result'
			$result = MySQLiAccess::call2("getTags", $args);
			
			
			//If there is a result, the buildModel method is called from the ModelFactory class to construct a new Tag object
            if ($result) {
				$ret = array();
				
				foreach ($result as $row) {
					 $ret[] = ModelFactory::buildModel("Tag", $row);
				}
				
            }
        }
        return $ret;
			 
	}
	
	
		 
	//Inserts a new tag into the database
	private static function insert(&$tag) {
		//A string, $args, is created to hold the attributes of the tag object that will be inserted into the database
		$args = MySQLiAccess::prepareString($tag->getTagId()).", ".
		MySQLiAccess::prepareString($tag->getTag());
		
		$result = MySQLiAccess::call("addTag", $args);
        if ($result) {
            $tag = ModelFactory::buildModel("Tag", $result[0]);
        } else {
            $tag = null;
        }
    }	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
 }


?>