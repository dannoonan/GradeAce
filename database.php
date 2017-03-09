<?php 
	$mysql_hostname  =  "localhost"; 
	$mysql_user  =  "Dan"; 
	$mysql_password  =  "password"; 
	$mysql_database  =  "gradeace"; 
	$bd  =  mysql_connect($mysql_hostname,  $mysql_user,  $mysql_password)  or  die("Could  not  connect  database");
	 mysql_select_db($mysql_database,  $bd)  or  die("Could  not  select  database"); 
	 $db  =  mysqli_connect($mysql_hostname,$mysql_user,$mysql_password,$mysql_database); 
?>
