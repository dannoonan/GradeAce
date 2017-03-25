<?php 
	$mysql_hostname  =  "localhost"; 
	$mysql_user  =  "root"; 
	$mysql_password  =  ""; 
	$mysql_database  =  "gradeace"; 
	$bd  =  mysqli_connect($mysql_hostname,  $mysql_user,  $mysql_password, $mysql_database)  or  die("Could  not  connect  database");
	 mysqli_select_db($bd, $mysql_database)  or  die("Could  not  select  database"); 
	 $db  =  mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database); 
	 
	 
	 
	 
	 
	function insert($link, $table, $fields, $values) {
			$fields = implode(", ", $fields);
			$values = implode("', '", $values);
			$sql="INSERT INTO $table (id, $fields) VALUES ('', '$values')";

			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			} else {
				return TRUE;
			}
		}
		
?>
