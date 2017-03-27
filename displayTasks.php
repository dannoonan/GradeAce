<?php
    require_once './daos/TaskDAO.class.php';
	require_once './daos/TagDAO.class.php';
?>
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
					<li><a href="./index.php">Home</a></li>
					<?php 
						if (isset($_SESSION["userId"]) && $_SESSION["userId"] != ''){ 
						//printf("<li><a href=\"./createTask.php\" class=\"\">Sell</a></li>");
						printf("<li><a href=\"./logout.php\" class=\"\">Logout</a></li>");
						} else {
							printf("<li><a href=\"./login.php\" class=\"\">Login</a></li>");
						}
					?>
				</ul>
			</nav>

		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="main">
					<div class="row">
						<div class="8u 12u(mobile)">
							<header>
								<h1>Welcome to <strong>GradeAce</strong>.</h1>
							</header>
							<?php
								if (isset($_GET["TaskId"])) {
									
									$TaskId = $_GET["TaskId"];
									$taskDao = new TaskDAO();
									
									try {
										$task = $taskDao->getTask($TaskId);
									} catch (Exception $e) {
										$task = null;
									}
									
									if (!is_null($task) ){
										printf("<h2> %s </h2> <p> %s </p>\n", $task->getTitle(), $task->getDescription());
									} else {
										printf("Task not found.");
									}
								}
							?>
							<ul class="actions small">
							  <?php
								if (!isset ($_SESSION)) {
									session_start();
								}
								if (isset($_SESSION["UserId"]) && $_SESSION["UserId"] != '') { 
							  ?>
									<li>
									  <a href="#" class="button">Claim</a>
									</li>
							  <?php } ?>
								<li>
							<a href="./index.php" class="button">Back</a>
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
		
	