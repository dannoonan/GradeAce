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
	
	public static function getTaskStatus($TaskId)
	{
		$result = MySQLiAccess::call2("getTaskStatus", $TaskId);
		$row = mysqli_fetch_assoc($result);
		return $row['Status'] ;
	}
	
	public static function getOwner($TaskId){
		$owner = null;
		 
		if(!is_null($TaskId)){
			
			$args = $TaskId;
			
			$result = MySQLiAccess::call2("getOwner", $args);
			
			if ($result) {
				$resultArray = $result->fetch_array();
                $owner = ModelFactory::buildModel("User", $resultArray);
            }
        }
        return $owner;
			 
	}
	
	public static function checkDeadline($TaskId, $function){
		$date = null;
		$deadlineProcedure = null;
		
		if($function == 1){
			$deadlineProcedure = "getDeadline1";
			
		}else if($function==2){
			$deadlineProcedure = "getDeadline2";
		}
		
		 
		if(!is_null($TaskId)){
			
			$args = $TaskId;
			
			$result = MySQLiAccess::call2($deadlineProcedure, $args);
			$row = mysqli_fetch_assoc($result);
			
			if($function ==1){
				$TestDate = $row['ClaimDate'] ;	
				
			}else if($function ==2){
				$TestDate = $row['CompleteDate'] ;
			}
			
			
			if( strtotime($TestDate) > strtotime('now') ) {
				$date=1;
            }
			else
				$date=0;
        }
        return $date;
			 
	}
	
	public static function getTaskClaimant($TaskId)
	{
		$claimant = null;
		$args = $TaskId;
		
		$result = MySQLiAccess::call2("getTaskClaimant", $args);
		if ($result) {
			$userIdArray = $result->fetch_array();
			$userId = $userIdArray[0];
			$args = $userId.","."''";
			$result2 = 	MySQLiAccess::call2("getUser", $args);
			if($result2){
				$resultArray = $result2->fetch_array();
                $claimant = ModelFactory::buildModel("User", $resultArray);
			}
        }
		return $claimant;
	}
	
	
	public static function claimTask($TaskId, $UserId){
		
		$args = null;
		$retVal = false;
		
		
		if(!is_null($TaskId)){
			
			$args = $TaskId;
			$args2 =$UserId.", ".$TaskId;

			

			
			//$result = MySQLiAccess::call("claimTask", $args);
			$result = MySQLiAccess::call2("claimTask", $args);
			$result2 = MySQLiAccess::call2("claimedTask", $args2);
			
			if($result&&$result2){
				$retVal = true;


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
	
	public static function CancelTask($taskId){
		if(!is_null($taskId)){
			
			$args = $taskId;
			
			$result = MySQLiAccess::call2("CancelTask", $args);
			
			if($result){
				$retVal = true;
			}
			else{
				$retVal = false;
				echo "Failed to Cancel Task claim";
			}
			
		}else{
			echo "TaskId not set";
		}
		return $retVal;
	}
	
	
	public static function flagTask($taskId){
		if(!is_null($taskId)){
			
			$args = $taskId;
			
			$result = MySQLiAccess::call2("flagTask", $args);
			
			if($result){
				$retVal = true;
			}
			else{
				$retVal = false;
				echo "Failed to Flags Task claim";
			}
			
		}else{
			echo "TaskId not set";
		}
		return $retVal;
	}
	
	public static function Unclaim($taskId){
		$retVal = null;
		
		if(!is_null($taskId)){
			
			$args = $taskId;
			
			$result = MySQLiAccess::call2("UnclaimTask", $args);
			
			if($result){
				$retVal = true;
			}else{
				$retVal = false;
			}
		}
	}
	
	public static function deleteTask($taskId){
		if(!is_null($taskId)){
			
			$args = $taskId;
			
			$result = MySQLiAccess::call2("deleteTask", $args);
			
			if($result){
				$retVal = true;
			}
			else{
				$retVal = false;
				echo "Failed to delete Task claim";
			}
			
		}else{
			echo "TaskId not set";
		}
		return $retVal;
	}
	
	public static function addReview($notes, $taskId){
		
		$args = MySQLiAccess::prepareString($notes).", ".$taskId;
		$status =2;
		$args2 = $taskId.",".$status;
		
		$result = MySQLiAccess::call2("addReview", $args);
		$result2 = MySQLiAccess::call2("updateStatus", $args2);
		
		
		if($result&&$result2){
			echo "Review added and status changed";
			return $result;
		}else if($result){
			echo "Review added - status not changed";
			return $result;
		}else{
			echo "Failed to add review";
			return $result;
		}	
	}
	//Checks whether the completeDate deadline has been passed and returns a boolean accordingly
	public static function reviewCheck($taskId){
		
		$retVal = null;
		$function=2;
		
		$result = self::checkDeadline($taskId, $function);
		
		if($result==0){
			$retVal = true;
			echo "deadline completeDate  passed////";
			
		}else{
			$retval = false;
			echo "deadline competeDate not passed////";
		}
		
		return $retVal;
		
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