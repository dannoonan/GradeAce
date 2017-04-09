<?php
    require_once __DIR__.'./daos/TaskDAO.class.php';
	require_once __DIR__.'./daos/TagDAO.class.php';
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
							printf("<li><a href=\"./Register.php\" class=\"\">Register</a></li>");
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
								if(isset($_SESSION['UserName'])){
								printf("<h1>Welcome to <strong>GradeAce</strong>,<a href=\"./profilePage.php\"> %s </a></h1>", $_SESSION['UserName']);
								}else{
									printf("<h1>Welcome to <strong>GradeAce</strong></h1>
									");
									?>\
									
									<a href="./login.php" class="button small">Login</a>
								<?php
								}
								
							?>
								
							</header>
							<?php

							require_once('load.php');
							
							if (isset($_SESSION["UserId"]) && $_SESSION["UserId"] != ''){
								
								$userId = $_SESSION['UserId'];
								
								$getCourse = mysqli_query($db, "SELECT `Course` FROM users WHERE `UserId`= '$userId'");
								$row = mysqli_fetch_assoc($getCourse);
								$userCourse = $row['Course'];
								
								$taskDao = new TaskDAO();
								try {
									
									$tasks = $taskDao->getAllTasks();	
									
								} catch (Exception $e) {
									$tasks = null;
								}
								if (!is_null($tasks)) {
									foreach ($tasks as $task) {

										$num=$task->getTaskId();
										$result=mysqli_query($db,"SELECT 1 FROM statustable WHERE `TaskId` = '$num' && `Status` = 0");
										$result2=mysqli_query($db,"SELECT 1 FROM tasks WHERE `TaskId` = '$num' && `TaskField` = '$userCourse'");
										if(($result && mysqli_num_rows($result) > 0)&&($result2 && mysqli_num_rows($result2) > 0))
											printf("<h2> <a href=\"./taskDisplay.php?id=%s\"> %s  -  %s</h2>", $task->getTaskId(), $task->getTitle(), $task->getTaskType());

									}
								}
							}
							?>
							
						</div>
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
		
	