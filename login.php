<html>

<body>
<?php

	include ("database.php");
	session_start();
	$username = $password = "";


	if($_SERVER["REQUEST_METHOD"]=="POST"){
		
		
	
		$username = test_input($_POST["name"]);
		$password = test_input($_POST["password"]);
		
		
		$result  =  mysql_query("SELECT  *  FROM  users"); 
			$c_rows  =  mysql_num_rows($result); 
			if  ($c_rows!=$username)  { 
				header("location:  index.php?remark_login=failed"); 
			}
		
		
		
		function test_input($data){
			
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		
	}
	
		echo $username;
		echo $password;
	}

?>

</body>
</html>