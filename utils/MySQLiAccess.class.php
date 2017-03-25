<?php 
class MySQLiAccess {
	
	private $error_msg     = '';
	private $connection;
	private static $instance = null;
	
	
	private function __construct() {
		$this->openConnection();
	}
	
	public static function getInstance() {
        if (!is_null(MySQLiAccess::$instance)) {
            return MySQLiAccess::$instance;
        } else {
            MySQLiAccess::$instance = new MySQLiAccess();
            return MySQLiAccess::$instance;
        }
    }
	
    private function openConnection() {
		$conn = false;
		$ret = false;
        $dbName = "gradeace";	//Settings::get('database.database');
        $server = "localhost";  //Settings::get('database.server');
		//Username can be changed accordingly
        $username = "root";	    //Settings::get('database.username');
        $password = "";	        //Settingstings::get('database.password');
		$conn = new mysqli($server, $username, $password, $dbName);
		
		unset($password); unset($dbName); unset($server);  unset($username);
		
		if (!$conn) {
            $this->error_msg = "\r\n" . "Unable to connect to database - " . date('H:i:s');
            $ret = false;
        } else {
            $this->connection = $conn;
            $ret = true;
        }
        return $ret;
	}
	
	public static function call($procedure, $procArgs) {
        $db = MySQLiAccess::getInstance();
        echo $procedure;
		echo $procArgs;
		
        if (!is_array($procArgs)&& !is_null($procArgs)) {
            $sql = "CALL $procedure ($procArgs)";
        } else if (!is_null($procArgs)) {
            $sql = "CALL $procedure ".implode(', ',$procArgs);
        }else{
			$sql = "CALL $procedure";
		}
        
        if ((empty($sql)) || (empty($db->connection))) {
            $db->error_msg = "\r\n" . "SQL Statement or connect is <code>null</code>" . date('H:i:s');
            return false;
        }
        
        $conn = $db->connection;
        $data = array();
		$newResult = array();
		echo $sql;
        if ($result = $conn->query($sql)) {
			echo "////got a connection////";
			if($result){
				echo "got a result////";
				$newResult = $result;
			}
        }
		 return empty($newResult) ? false : $newResult;
		
		
		//return empty($data) ? false : $data;

    }
	
	public static function prepareString($string) {
		$db = MySQLiAccess::getInstance();
		$conn = $db->connection;
		$x="'".$string."'";
		return $x;
	}
} 
?>
