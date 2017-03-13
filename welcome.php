<?php
		session_start();
		include 'database.php';
		
		$id = $_SESSION['id'];

		$sql = "SELECT * FROM users WHERE UserID ='$id'";
		$query = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($query);
		
		$fname = $row['FirstName'];
		
		
		if($_SESSION['id']){
			
			echo "Welcome ";
			echo  $fname ;
			echo $id;
		}
		else{
			echo "welcome but id not specified";
		}
		

?>

