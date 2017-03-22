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
        
        if (!is_array($procArgs)) {
            $sql = "CALL $procedure ($procArgs)";
        } else {
            $sql = "CALL $procedure ".implode(', ',$procArgs);
        }
        
        if ((empty($sql)) || (empty($db->connection))) {
            $db->error_msg = "\r\n" . "SQL Statement or connect is <code>null</code>" . date('H:i:s');
            return false;
        }
        
        $conn = $db->connection;
        $data = array();
        if ($result = $conn->query($sql)) {
            foreach ((array)$result as $row) {
                $data[] = $row;
            }
        }
		
        return empty($data) ? false : $data;

    }
	
	public static function prepareString($string) {
		$db = MySQLiAccess::getInstance();
		$conn = $db->connection;
		$x="'".$string."'";
		return $x;
	}
} 
?>
