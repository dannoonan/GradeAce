<?php
    require_once __DIR__.'/daos/UserDAO.class.php'; 
?>

<html>
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
						//printf("<li><a href=\"./createTask.php\" class=\"\">Sell</a></li>");
						printf("<li><a href=\"./logout.php\" class=\"\">Logout</a></li>");
					} else {
						printf("<li><a href=\"./Register.php\" class=\"\">Register</a></li>");
					}
          ?>
				</ul>
			</nav>

		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container 75%" id="login">
					<div class="row">
						
					<?php
						
						if(isset($_POST['login_btn'])){
							
							try{
								//remember to strip tags and slashes 
								$email = $_POST["email"];
								$password = $_POST["pass"];
								
								$userDAO = new UserDAO();
								$user= $userDAO->login($email, $password);
								$ban = null;
								
								if($user)
								{
									//Test to see if th user is banned
									$userId = $user->getUserId();
									$IsBanned = $userDAO->IsBanned($userId);
									$ban='All Ok';
										if($IsBanned == 1)
										{
											printf("<h2> This User is banned! </h2>");
											$ban=null;
										}
									
									//Not Neccessary!!!!!
									//$userDAO->logout(); 
								}
								
								 if (!is_null($user) && !is_null($ban)) {
									
									
									$_SESSION['UserId'] = $user->getUserId(); 
									$_SESSION['UserName'] = $user->getFirstName();
									header("Location:./index.php");
								}else {
									If(!is_null($ban))
									printf("<h2> Password incorrect or account not found. </h2>");
								}
							}catch (Exception $exception) {
									printf("Connection error: %s", $exception->getMessage());
							}
						}
					?>
						<div class="11u 12u(mobile)">
							<header>
								<h1>Welcome to <strong>GradeAce</strong>.</h1>
							</header>
							<form action="login.php" method="post">
							<input type="text" name="email" placeholder="Please enter your email address">
							<input type="password" name="pass" placeholder="Please enter your password">

							<input type="submit" value="Login" name = "login_btn">
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

							<input type="button" value="Register Now" onclick="window.open('Register.php', '_self')">
			
							</div>
						</div>
						
					</div>
					<footer>
						<ul id="copyright">
							<li>© GradeAce. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
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
		
	