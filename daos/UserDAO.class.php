<?php
require_once __DIR__.'/../models/User.class.php';
require_once __DIR__.'/../utils/ModelFactory.class.php';
require_once __DIR__.'/../utils/MySQLiAccess.class.php';

class UserDAO {
    public static function getUser($UserId, $Email) {
		
        $user = null;
        if (!is_null($UserId) || !is_null($Email)) {
		
            $args = $UserId.", ".MySQLiAccess::prepareString($Email);
            $result = MySQLiAccess::call("getUser", $args);
			
			
            if ($result) {
				$resultArray = $result->fetch_array();	
                $user = ModelFactory::buildModel("User", $resultArray);
            }
        }
        return $user;
    }
	
	public static function save($user) {
       if (is_null($user->getUserId())) {
            self::insert($user);
       }/*else {
            self::update($user);
        }*/
        return $user;
    }
	
	private static function insert(&$user) {
		$siteSalt  = "gradeace";
		$saltedHash = hash('sha256', $user->getPassword().$siteSalt);
		
		$args = 
		MySQLiAccess::prepareString($user->getFirstName()).", ".
		MySQLiAccess::prepareString($user->getLastName()).", ".
		MySQLiAccess::prepareString($user->getEmail()).", ".
		MySQLiAccess::prepareString($user->getCourse()).", ".
		MySQLiAccess::prepareString($saltedHash);

		$result = MySQLiAccess::call("addUser", $args);
        if ($result) {
            $user = ModelFactory::buildModel("User", $result[0]);
        } else {
            $user = null;
        }
    }
	
	public static function login($Email, $password) {

		
		$user = self::getUser("''",$Email);
		
		if (!is_null($user)) {
			$id = $user->getUserId();
			$passwordHash = $user->getPassword();
			$siteSalt  = "gradeace";
			$saltedHash = hash('sha256', $password.$siteSalt);
			

			if ($passwordHash == $saltedHash) {
				
				return $user;
			}
        return null;
		}
	}
	

	public static function logout() {
		/*http://php.net/manual/en/function.session-unset.php*/
		if (!isset ($_SESSION)) {
			session_start();
		}
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		//session_regenerate_id(false);	
	}	
}
?>