<?php include  "login.php"; ?>
<!DOCTYPE  html>
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
							</header>
							<form action="login.php" method="post">
							 <?php
								$remarks  =  isset($_GET['remark_login'])  ?  $_GET['remark_login']  :  '';
								if  ($remarks==null  and  $remarks==""){
									echo  '
											<div  id="reg-head"  class="headrg">Login  Here</div>
 
									';
								}
								if  ($remarks=='failed'){
									echo  '
									<div  id="reg-head-fail"  class="headrg">Login  Failed!  Invalid  Credentials</div>
 
									';
								}
							?>
							<input type="text" name="email" placeholder="Please enter your email address">
							<input type="text" name="pass" placeholder="Please enter your password">

							<input type="submit" value="Login">
							</form>


						</div>
					</div>
				</article>
			</div>

		<!-- Work -->
			

		
			

		
			<div class="wrapper style4" id ="register">
				<article id="contact" class="container 75%">
					<header>
						<h2>Get the right advice when you need it</h2>
						<p>Register an account with us today</p>
					</header>
					<div>
						<div class="row">
							<div class="12u">
								<form action="formSubmission.php" method="post">
								<input type="text" name="fname" placeholder="Please enter your first name"><br>
							<input type="text" name="lname" placeholder="Please enter your last name"><br>
							<input type="text" name="email" placeholder="Please enter your email address"><br>
							<input type="text" name="pass" placeholder="Please enter a password"><br>
							<input type="submit" value="Register">
							</form>
								
								
								
								
								
								
								
								
							</div>
						</div>
						
					</div>
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
		
	