<?php
    require_once __DIR__.'/daos/UserDAO.class.php';   
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
					<li><a href="./index.php">Home</a></li>
					<?php 
					 if (!isset ($_SESSION)) {
						session_start();
					}
					
                if (isset($_SESSION["UserId"]) && $_SESSION["UserId"] != ''){ 
                    //printf("<li><a href=\"./createTask.php\" class=\"\">Create Task</a></li>");
                    printf("<li><a href=\"./logout.php\" class=\"\">Logout</a></li>");
                } else {
                    printf("<li><a href=\"./login.php\" class=\"\">Login</a></li>");
                }
          ?>
				</ul>
			</nav>

		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container 75%" id="login">
					<div class="row">
						
						<div class="11u 12u(mobile)">
							<header>
							<h1>Welcome to <strong>GradeAce</strong>.</h1>
							<?php 
								if (!isset($_POST) || count($_POST) == 0) { 
									printf("<h2>Create an account by filling in the details below.</h2>");
									
								}
								?>
							</header>
							<?php

								
								
								require_once('load.php');
								
								//when the register button is pressed after the form has been filled
								if (isset($_POST['register_btn'])){
									
									//Takes in all the information is entered
									$FirstName=($_POST['FirstName']);
									$LastName=($_POST['LastName']);
									$Email=($_POST['Email']);
									$Course=($_POST['Course']);
									$Password=($_POST['Password']);
									$Password2 = ($_POST['Password2']);
									
									$userDAO = new UserDAO();

									$userTester = $userDAO->getUser("''", $Email);
									
									//ensures the passwords match
									if($Password == $Password2){ 
									
										//Ensures the emails is not already in use
										 if (!is_null($userTester)) { 
														printf("<h2> There is already an account with that email address</h2>");
													} else{

														//hash the password
														$siteSalt  = "gradeace";
														$saltedHash = hash('sha256', $Password.$siteSalt);
														
														//Creates the new user and adds to users table in database
														$user = new User();
														$user->setFirstName($FirstName);
														$user->setLastName($LastName);
														$user->setEmail($Email);
														$user->setCourse($Course);
														$user->setPassword($Password);
														$user = $userDAO->save($user);
														$userTest = $userDAO->login($Email, $Password);
														$userId = $userTest->getUserId();
														//add to ban table with default value 0
														$userDAO->addban($userId);
														
														if (!is_null($user)) {
																printf("<h2> Welcome %s! Please <a href=\"./login.php\"> login </a> to proceed. </h2>", $user->getFirstName());
														}
													}

										
										
									}else{
										printf( "<h2>Passwords don't match</h2>");
									}
								}									
								

							?>
							
							<?php 
								if (!isset($_POST) || count($_POST) == 0) { 
							?>
								
								<!-- Form for entering new user information -->
								<form action="Register.php" method="post">
								
								<input type="text" name="FirstName" placeholder="Please enter your first name">
								<input type="text" name="LastName" placeholder="Please enter your last name">
								<input type="email" name="Email" placeholder="Please enter your email">
								<select name="Course">
									<option value="">Select...</option>
									<option value="Computing">Computing</option>
									<option value="Engineering">Engineering</option>
									<option value="Humanities">Humanities</option>
									<option value="Business">Business</option>
									<option value="Science">Science</option>
									<option value="Medicine">Medicine</option>
									<option value="Law">Law</option>
								</select>
								<input type="password" name="Password" placeholder="Please enter your password">
								<input type="password" name="Password2" placeholder="Please enter your password again">

								<input type="submit" value="Register" name="register_btn">
								<h4>(Once Registered please log in)</h4>
								</form>
								
								<?php 
								}
								?>

						</div>
					</div>
				</article>
			</div>
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