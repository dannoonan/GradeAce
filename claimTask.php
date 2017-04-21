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
					//if the session has not been started, start it now
						if (!isset ($_SESSION)) {
							session_start();
						}
						//if the session user id is set the nav bar will contain elements that are otherwise hidden
						if (isset($_SESSION["UserId"]) && $_SESSION["UserId"] != ''){ 
						printf("<li><a href=\"./logout.php\" class=\"\">Logout</a></li>");
						printf("<li><a href=#>Create a Task</a></li>");
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
								require_once('load.php');
							
								if (isset($_SESSION["UserId"])&& isset($_SESSION["TempTaskId"])) {
									//taskId variable created to hold the temporary session taskid
									$TaskId = $_SESSION["TempTaskId"];
									//userId variable created to hold the session userId
									$UserId = $_SESSION["UserId"];
									//Task and user DAOs created
									$taskDAO = new TaskDAO();
									$UserDAO = new UserDAO();
									
									//Try catch block to create a task object
									try{
										$task = $taskDAO->getTask($TaskId);
									}catch(exception $e){
										$task = null;
									}
									//if the task object creation is successful					
									 if (!is_null($task)&&!is_null($TaskId)){
											//UserDAO object created, then used to create a user object using the userId
											$User = $UserDAO->getUser($UserId, null);
											//User's email is then retrieved using the User object method
											$UserEmail = $User->getEmail();
											//TaskId is retrieved using the task object method 
											$TId=$task->getTaskId();
											/*An owner is a user object that corresponds to the owner of the task, it is retrieved using a method that taked the 
											 taskid of the owned task, then finds its owner and creates a user object. From this the owner's id and email can be found*/ 
											$OwnerPerson = $taskDAO->getOwner($TId);
											$OwnerId = $OwnerPerson->getUserId();
											//$OwnerId = ($taskDAO->getOwner($TId))->getUserId();
											$Owner = $UserDAO->getUser($OwnerId, null);
											$OwnerEmail = $Owner->getEmail();
											/*ClaimTask associates the user, who wishes to claim the task, with the task they are claiming. In the 
											claimed table, their ID will be associated with the ID of the task they have claimed*/
											$claimResult = $taskDAO->claimTask($TaskId, $UserId);
											
											
											$userRep = $User->getReputation();
											$newUserRep = $userRep +10;
											$updateRepQuery = $UserDAO->updateReputation($UserId, $newUserRep);
											
											
											//Old Procedural
											//$query = "UPDATE users SET Reputation = Reputation + '10' WHERE UserId = $UserId";
											//mysqli_query($db, $query);
											
											//Send the email to the owner of the task, stating the claim, and asking for the full task
											$to      = $OwnerEmail;
											$subject = 'Task Claim';
											$message = 'A user would like to claim the task '.$task->getTitle().'.\n Please forward on the file to '.$UserEmail;
											$header = "From: noreply@example.com\r\n"; 
												
											//echo $UserEmail.", ".$OwnerEmail.", ".$task->getTitle();
											//mail($to, $subject, $message, $header);
											
											if($claimResult){
												?>
												<h1>Task claimed successfully</h1>
												
												<?php
												
											}else{
												echo "Failed to claim task";
											}
											
											
									} else {
											printf("Could not claim Task - UserId or TaskId not set");
									}
									
								}
							?>
							<ul class="actions small">
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
		