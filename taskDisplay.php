<?php
    require_once __DIR__.'./daos/TaskDAO.class.php';
	require_once __DIR__.'./daos/TagDAO.class.php';
	require_once __DIR__.'./utils/MySQLiAccess.class.php';
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
								
							
							if (isset($_GET["id"])) {
								
								$displayTaskId = $_GET["id"];
								$_SESSION["TempTaskId"]= $displayTaskId;
								$taskDAO = new TaskDAO();
								$tagDAO = new TagDAO();
								
								try{
									$task = $taskDAO->getTask($displayTaskId);
								}catch(exception $e){
									$task = null;
								}
								
								try{
									$tags = $tagDAO->getTags($displayTaskId);
								}catch(exception $e){
									$tags = null;
								}
								
								 if (!is_null($task) ){
										printf("<h1> %s </h1> \n", $task->getTitle());
										printf("<h2>Description:  </h2><h4>%s</h4>", $task->getDescription() );
										printf("<h2>Pages: </h2><h4>%s</h4>", $task->getPages());
										printf("<h2>Words: </h2><h4>%s</h4>",$task->getWords() );
										printf("<h2>Claim deadline: </h2><h4>%s</h4>",$task->getClaimDate() );
										printf("<h2>Complete Task deadline: </h2><h4>%s</h4>",$task->getCompleteDate() );
										
										//Task Status
										$status = $taskDAO->getTaskStatus($displayTaskId);
										if($status == 0)
											$statusString = "Pending Claim";
										else if($status == 1)
											$statusString = "Claimed";
										else if($status == 2)
											$statusString = "Completed";
										else if($status == 3)
											$statusString = "Cancelled";
										else if($status == 4)
											$statusString = "Unclaimed";
										printf("<h2>Task Status: </h2><h4>%s</h4>",$statusString);
										
										if(!is_null($tags)){
											printf("<h2>Tags: </h2>");
											foreach($tags as $tag){
												
												printf("<h4>%s</h4>", $tag->getTag());
												
											}
										}
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
									if (!isset($_GET["function"])) {
							  ?>
									<li>
									  <a href="./claimTask.php" class="button small">Claim Task</a>
									</li>
									<li>
									  <a href="?ok=.'$id'." class="button Small">Download Preview</a> <br>
									</li>
								<?php
									 if ( isset($_REQUEST['ok']) ) {
											$TaskId = $_SESSION["TempTaskId"];
											MySQLiAccess::Download($TaskId);
									 }
								?>
									<li>
									  <a href=# class="button small">Flag Task</a>
									</li>
							  <?php 
									} else if (isset($_GET["function"]) && $_GET["function"] == 1) {
								?>
									<li>
									  <a href="./reviewTask.php" class="button small">Review Task</a>
									  <a href="./Cancel.php" class="button small">Cancel Claimed Task</a>
									</li>
								
								<?php
									}else if (isset($_GET["function"]) && $_GET["function"] == 2) {
										
										if(($taskDAO->getTaskStatus($displayTaskId)) != 0){
											?>
											<li>
												<a href="./Claimant.php?id=<?php echo $displayTaskId ?>" class="button small">View Claimant Details</a>
											</li>
											<?php
										}
								
										if(!(is_null($task->getNotes()))){
											?>
											<li>
												<a href="./viewReview.php" class="button small">View Reviewers Notes</a>
											</li>
											<?php
										}
									}
									else if (isset($_GET["function"]) && $_GET["function"] == 3)
									{?>
										<li>
											<a href="./Ban.php?function=1" class="button small">Unpublish Task</a>
										</li>
										<li>
											<a href="./Ban.php?function=2" class="button small">Unpublish Task & Ban User</a>
										</li>
									<?php
									}
								}
								?>
								<li>
								  <a href="./index.php" class="button small">Back</a>
								</li>
						  </ul>
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
		