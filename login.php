<?php
	session_start();
	if(isset($_POST['login_btn'])){
		
		include 'database.php';
		//remember to strip tags and slashes 
		$email = $_POST['email'];
		$password = $_POST["pass"];
		
		//$password = md5($password);
		
		$sql = "SELECT * FROM users WHERE Email ='$email'";
		$query = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($query);
		
		$db_email = $row['Email'];
		$db_password = $row['Password'];
		
		
		if($password == $db_password){
			$_SESSION['id'] = $row['UserId'];
			
			$_SESSION['email'] = $email;
		
			if($_SESSION['id']){
			header("Location: welcome.php");
			}
			else{
				echo "No id";
			}
		}
		else{
			echo "incorrect email or password";
			
		}
		
		
		
	}
		?>