<?php
 require_once __DIR__ . "/.../models/Task.class.php";
 require_once __DIR__ . "/.../utils/MySQLi.class.php";
 require_once __DIR__ . "/.../utils/ModelFactory.class.php";

 
 Class TaskDAO {
	 
	 
	public static function getTask($TaskId){
		 
		$task = null;
		 
		if(!is_null($TaskId)){
			/*Creates args to pass to the MySQLiAccess class's call method, thereby using an SQL statment
			to retrieve the desired task from the database*/
			$args = $TaskId;
			
			//The results from the database, after being retrieved by the MySQLiAccess call method, are stored in the variable '$result'
			$result = MySQLiAccess::call("getTask", $args);
			
			//If there is a result, the buildModel method is called from the ModelFactory class to construct a new Task object
            if ($result) {
                $task = ModelFactory::buildModel("Task", $result[0]);
            }
        }
        return $task;
			 
	}
	
	 public static function getAllTasks() {
        $args = "";
	    $result = MySQLiAccess::call("getAllTasks", $args);
        $ret = null;
        if ($result) {
            $ret = array();
            foreach ($result as $row) {
                 $ret[] = ModelFactory::buildModel("Task", $row);
            }
        }
        return $ret;	
    }	
		 
	//Inserts a new task into the database
	private static function insert(&$task) {
		//A string, $args, is created to hold the attributes of the task object that will be inserted into the database
		$args = MySQLiAccess::prepareString($task->getTaskId()).", ".
		MySQLiAccess::prepareString($task->getTitle()).", ".
		MySQLiAccess::prepareString($task->getTaskType()).", ".
		MySQLiAccess::prepareString($task->getDescription()).", ".
		MySQLiAccess::prepareString($task->getPages()).", ".
		MySQLiAccess::prepareString($task->getWords()).", ".
		MySQLiAccess::prepareString($task->getFileFormat()).", ".
		MySQLiAccess::prepareString($task->getFilePath()).", ".
		MySQLiAccess::prepareString($task->getClaimDate()).", ".
		MySQLiAccess::prepareString($task->getCompleteDate()).", ".
		MySQLiAccess::prepareString($task->getNotes());
		
		$result = MySQLiAccess::call("addTask", $args);
        if ($result) {
            $task = ModelFactory::buildModel("Task", $result[0]);
        } else {
            $task = null;
        }
    }

	
	
   
	 
	 	 
 }


?>