<?php
    require_once __DIR__.'./daos/TaskDAO.class.php';
	require_once __DIR__.'./daos/TagDAO.class.php';
	require_once __DIR__.'./utils/MySQLiAccess.class.php';
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
						
						//ensures user is logged in
						
						if (isset($_SESSION["UserId"]) && $_SESSION["UserId"] != ''){ 
						//printf("<li><a href=\"./createTask.php\" class=\"\">Sell</a></li>");
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
							
							</header>
							<?php
								
							//gets user ID and creates user object
							if (isset($_GET["id"])) {
								
								$displayTaskId = $_GET["id"];
								$_SESSION["TempTaskId"]= $displayTaskId;
								$taskDAO = new TaskDAO();
								$claimant = $taskDAO->getTaskClaimant($displayTaskId);								
								try{
									$task = $taskDAO->getTask($displayTaskId);
								}catch(exception $e){
									$task = null;
								}
								
								if(!is_null($claimant)){
								
								//displays users name and email
								 if (!is_null($task) ){
										printf("<h1> %s </h1> \n", $task->getTitle());
										printf("<h1>Claimants Details</h1>");
										printf("<h2>First Name:  </h2><h4>%s</h4>", $claimant->getFirstName() );
										printf("<h2>Last Name: </h2><h4>%s</h4>", $claimant->getLastName());
										printf("<h2>Email: </h2><h4>%s</h4>",$claimant->getEmail() );
								 }
							}
							else{
								printf("<h1> Task Cancelled due to not being</h1> \n");
								printf("<h1>  claimed before Deadline.</h1>");
							}
							}
							

							?>
							
								<li>
								  <a href="./index.php" class="button small">Back</a>
								</li>
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