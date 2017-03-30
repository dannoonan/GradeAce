<?php
    require_once __DIR__.'./daos/TaskDAO.class.php';
	require_once __DIR__.'./daos/TagDAO.class.php';
	require_once __DIR__.'./daos/UserDAO.class.php';
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
						printf("<li><a href=\"./logout.php\" class=\"\">Logout</a></li>");
						printf("<li><a href=\"./CreateTask.php\">Create a Task</a></li>");
						printf("<li><a href=\"./profilePage.php\">Profile</a></li>");
						} else {
							printf("<li><a href=\"./login.php\" class=\"\">Login</a></li>");
						}
					?>
				</ul>
			</nav>

		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container 75%" id="main">
					<div class="row">
						<div class="11u 12u(mobile)">
							<header>
							<?php
							require_once('load.php');
								if(isset($_SESSION['UserName'])){
									
									$id = $_SESSION['UserId'];
									$userDAO = new UserDAO();
									$user = $userDAO->getUser($id, "");
									
									if(!is_null($user)){
										printf("<h1>%s</h1>", $user->getFirstName());
										printf("<h2>Reputation: %d</h2>", $user->getReputation());
										printf("<h2>Course: %s</h2>", $user->getCourse());
										
									}
								
								
								
								
								}else{
									printf("<h1>Welcome to <strong>GradeAce</strong></h1>");
									?>
									
									<a href="./login.php" class="button small">Login</a>
								<?php
								}
								
							?>
							</header>
							
								<section class="box style1">
									<a href="./myTasks.php" <span class="icon featured fa-comments-o"></span>
									<h3>My Tasks</h3>
								</section></a>
							
							
								<section class="box style1">
									<a href="./claimedTasks.php" <span class="icon featured fa-comments-o"></span>
									<h3>Claimed Tasks</h3>
								</section></a>
							
					</div>
				</article>
			</div>

		<!-- Work -->
			

		
			

		
			<div class="wrapper style4" id ="register">
				<article id="contact" class="container 75%">
				<?php
					if(!isset($_SESSION['UserId'])){ ?>
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
				<?php		
					}
				?>
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
		
	