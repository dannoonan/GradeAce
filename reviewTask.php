<?php
	
	 require_once __DIR__.'./daos/TaskDAO.class.php';
	 require_once __DIR__.'./daos/TagDAO.class.php';
	
	
	session_start();
	require_once('load.php');
	
	if(isset($_POST['review_btn'])){
		
		$notes = $_POST['notes'];
		$taskId = $_SESSION["TempTaskId"];
		$userId = $_SESSION["UserId"];
		
		if(!is_null($notes)){
			
			$taskDAO = new TaskDAO();
			
			try{
				$task = $taskDAO->getTask($taskId);
			}catch(exception $e){
				$task = null;
			}
			
			if(!is_null($task)&&!is_null($taskId)){
				
				$result = $taskDAO->addReview($notes, $taskId);
				$query = "UPDATE users SET Reputation = Reputation + '10' WHERE UserId = $userId";
				mysqli_query($db, $query);
				
				
				if($result){
					echo "Review added successfully";
				}else{
					echo "Failed to add review";
				}
				
			}
			
		}
		
	header("Location:./index.php");	
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
					<li><a href="./index.php">Home</a></li>
					<li><a href=\"./logout.php\" class=\"\">Logout</a></li>
				</ul>
			</nav>

		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="login">
					<div class="row">
						
						<div class="11u 12u(mobile)">
							<header>
								<h1>Review Task</h1>
								<h2>Submit your review of this task</h2>
							</header>
							
							<form action="reviewTask.php" method="post" enctype="multipart/form-data" id="reviewForm">
							
							<textarea name="notes" rows="4" cols="50" form="reviewForm" required></textarea>
							<input type="submit" value="Submit Review" name="review_btn">
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