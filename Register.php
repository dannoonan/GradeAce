<?php

	session_start();
	
	require_once('load.php');
	
	if (isset($_POST['register_btn'])){
		$FirstName=($_POST['FirstName']);
		$LastName=($_POST['LastName']);
		$Email=($_POST['Email']);
		$Course=($_POST['Course']);
		$Password=($_POST['Password']);
			
		$sql = "INSERT INTO users(FirstName, LastName, Email, Course, Password) VALUES('$FirstName', '$LastName', '$Email', '$Course', '$Password')";
		mysqli_query($db, $sql);
		header("location: index.php");
	}

?>

<html>
<head>
		<meta name="viewport" content="initial-scale=1"><meta name="viewport" content="user-scalable=yes,width=device-width,initial-scale=1"><meta name="viewport" content="initial-scale=1"><meta name="viewport" content="user-scalable=yes,width=device-width,initial-scale=1"><title>GradeAce</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css">
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	</head>
	<body class="">

		<!-- Nav -->
			<nav id="nav">
				<ul class="container">
					<li><a href="#login">Login</a></li>
					<li><a href="#register">Register</a></li>
					<li><a href="#portfolio">About</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</nav>

		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="login">
					<div class="row">
						
						<div class="8u 12u(mobile)">
							<header>
								<h1>Welcome to <strong>GradeAce</strong>.</h1>
								<h2>Create an account by filling in the details below.</h2>
							</header>
							
							<form action="Register.php" method="post">
							
							<input type="text" name="FirstName" placeholder="Please enter your first name">
							<input type="text" name="LastName" placeholder="Please enter your last name">
							<input type="email" name="Email" placeholder="Please enter your email">
							<input type="text" name="Course" placeholder="Please enter your course">
							<input type="text" name="Password" placeholder="Please enter your password">

							<input type="submit" value="Register" name="register_btn">
							</form>


						</div>
					</div>
				</article>
			</div>

		<!-- Work -->
			

		
			

		
			<div class="wrapper style4" id ="register">
				<article id="contact" class="container 75%">
					<footer>
						<ul id="copyright">
							<li>© Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>
				</article>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/skel-viewport.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	

</body>
</html>
		
	