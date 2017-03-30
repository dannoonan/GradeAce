<?php
 require_once __DIR__.'/../models/Task.class.php';
 require_once __DIR__.'/../utils/MySQLiAccess.class.php';
 require_once __DIR__.'/../utils/ModelFactory.class.php';

 
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
	
	/*public static function changeTaskStatus( $UserId, $TaskId){
		
		$args = null;
		$retVal = false;
		
		
		if(!is_null($TaskId)&&!is_null($UserId)){
			
			$args = $UserId.", ".$TaskId;
			echo "test var types////";
			
			//$result = MySQLiAccess::call("claimTask", $args);
			$result = MySQLiAccess::call2("claimTask", $args);
			
			if($result){
				$retVal = true;
				echo "task has been claimed////";
			}
			else{
				$retVal = false;
				echo "Failed to insert TaskId, UserId tuple into database";
			}
			
		}else{
			echo "TaskId or UserId not set";
		}
		return $retVal;
		
	}*/
	
	public static function claimTask($TaskId){
		
		$args = null;
		$retVal = false;
		
		
		if(!is_null($TaskId)){
			
			$args = $TaskId;

			echo "test var types////";

			
			//$result = MySQLiAccess::call("claimTask", $args);
			$result = MySQLiAccess::call2("claimTask", $args);
			
			if($result){
				$retVal = true;

				echo "task has been claimed////";

			}
			else{
				$retVal = false;
				echo "Failed to insert TaskId, UserId tuple into database";
			}
			
		}else{
			echo "TaskId or UserId not set";
		}
		return $retVal;
		
	}
	
	public static function addReview($notes, $taskId){
		
		$args = $notes.", ".MySQLiAccess::prepareString($taskId);
		
		$result = MySQLiAccess::call2("addReview", $args);
		
		
		if($result){
			echo "Review added";
		}else{
			echo "Failed to add review";
		}
		
		
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