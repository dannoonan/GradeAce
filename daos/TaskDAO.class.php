<?php
 require_once __DIR__.'/../models/Task.class.php';
 require_once __DIR__.'/../utils/MySQLiAccess.class.php';
 require_once __DIR__.'/../utils/ModelFactory.class.php';

 
 Class TaskDAO {
	 
	 
	public static function getTask($TaskId, $Title){
		 
		$task = null;
		 
		if (!is_null($TaskId) || !is_null($Title)) {
		
            $args = $TaskId.", ".MySQLiAccess::prepareString($Title);

            $result = MySQLiAccess::call("getTask", $args);
			
			
            if ($result) {
				$resultArray = $result->fetch_array();
                $task = ModelFactory::buildModel("Task", $resultArray);
            }
        }
        return $task;
			 
	}
	
	 public static function getAllTasks() {
        $args = null;
		
	    $result = MySQLiAccess::call("getAllTasks", $args);
        $ret = null;
        if ($result) {
			$result;
			
            $ret = array();
			
			
            foreach ($result as $row) {
				
				
                 $ret[] = ModelFactory::buildModel("Task", $row);
            }
        }
        return $ret;	
    }	
		 
	//Inserts a new task into the database
	public static function insert(&$task) {
		$Title=$task->getTitle();
		//A string, $args, is created to hold the attributes of the task object that will be inserted into the database
		$args = MySQLiAccess::prepareString($task->getTitle()).", ".
		MySQLiAccess::prepareString($task->getTaskType()).", ".
		MySQLiAccess::prepareString($task->getDescription()).", ".
		MySQLiAccess::prepareString($task->getPages()).", ".
		MySQLiAccess::prepareString($task->getWords()).", ".
		MySQLiAccess::prepareString($task->getFileFormat()).", ".
		MySQLiAccess::prepareString($task->getFilePath()).", ".
		MySQLiAccess::prepareString($task->getClaimDate()).", ".
		MySQLiAccess::prepareString($task->getCompleteDate());
				
		$result = MySQLiAccess::call2("addTask", $args);
		
        if ($result) {
			echo "HERE";
			$task = self::getTask("''",$Title);
        } else {
            $task = null;
        }
		return $task;
    }

	
	
   
	 
	 	 
 }


?>