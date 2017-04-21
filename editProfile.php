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
							
							if(isset($_SESSION["editStatusMessage"])){
								$editStatusMessageThis = $_SESSION["editStatusMessage"];
								printf("<h2>%s</h2>", $editStatusMessageThis);	
							}
								
							
							$editStatusMessage = "";
							$_SESSION["editStatusMessage"]=$editStatusMessage;
							
								if(isset($_SESSION['UserName'])){
									
									$id = $_SESSION['UserId'];
									
									
									$userDAO = new UserDAO();
									$user = $userDAO->getUser($id, "");
									
									
									if(!is_null($user)){
										if(isset($_POST['change_name_btn'])&&$_POST['FirstName']!=""&&$_POST['LastName']!=""){
											
											$firstName= $_POST['FirstName'];
											$lastName= $_POST['LastName'];

											$functionFName = 1;
											$functionLName = 2;
											
											$resultFName = $userDAO->editProfile($id, $firstName, $functionFName);
											$resultLName = $userDAO->editProfile($id, $lastName, $functionLName);
											
											if($resultFName&&$resultLName){
												echo "name changed";
												$editStatusMessage ="name changed";
												$_SESSION["editStatusMessage"]=$editStatusMessage;
											}else{
												echo "failed to change name";
												$editStatusMessage ="failed to change name";
												$_SESSION["editStatusMessage"]=$editStatusMessage;
											}
											
										}
										
										if(isset($_POST['change_email_btn'])&&$_POST['NewEmail']!=""){
											
											$email= $_POST['NewEmail'];
											$functionEmail = 3;					
											$resultEmail = $userDAO->editProfile($id, $email, $functionEmail);
																						
											if($resultEmail){
												echo "email changed";
												$editStatusMessage ="email changed";
												$_SESSION["editStatusMessage"]=$editStatusMessage;
											}else{
												echo "failed to change email";
												$editStatusMessage ="failed to change email";
												$_SESSION["editStatusMessage"]=$editStatusMessage;
											}
											
										}
										if(isset($_POST['change_password_btn'])&&$_POST['NewPassword1']!=""&&$_POST['NewPassword2']!=""){
											
											$oldPassword= $_POST['OldPassword'];
											$newPassword1= $_POST['NewPassword1'];
											$newPassword2= $_POST['NewPassword2'];
											
											$passwordCheckHash = $user->getPassword();											
																					
											$siteSalt  = "gradeace";
											$saltedHash = hash('sha256', $oldPassword.$siteSalt);
											
											if($saltedHash==$passwordCheckHash){
												
												if($newPassword1==$newPassword2){
													$siteSalt  = "gradeace";
													$saltedHash = hash('sha256', $newPassword1.$siteSalt);
													
													$functionPassword = 4;

													$resultEmail = $userDAO->editProfile($id, $saltedHash, $functionPassword);
													
													
													if($resultEmail){
														echo "password changed";
														$editStatusMessage ="password changed";
														$_SESSION["editStatusMessage"]=$editStatusMessage;
													}else{
														echo "falied to change password";
														$editStatusMessage ="falied to change password";
														$_SESSION["editStatusMessage"]=$editStatusMessage;
													}
												
												}else{
													echo "New passwords don't match";
													$editStatusMessage =$editStatusMessage."  New passwords don't match";
													$_SESSION["editStatusMessage"]=$editStatusMessage;
												}
											}else{
												echo "Old password doesn't match don't match";
												$editStatusMessage =$editStatusMessage."  Old password don't match";
												$_SESSION["editStatusMessage"]=$editStatusMessage;
											}
										
											
											
											
										}
										
										
										
									}
									
								
								
								
								}else{
									printf("<h1>Welcome to <strong>GradeAce</strong></h1>");
									?>
									
									<a href="./login.php" class="button small">Login</a>
								<?php
								}
								
							?>
							<h1>Edit Profile</p>
							</header>
							
								<section class="box style1">
									<form action="editProfile.php" method="post">
									<h2>Edit your name</h2>
									<input type="text" name="FirstName" placeholder="Please enter your first name">
									<input type="text" name="LastName" placeholder="Please enter your last name">
									<input type="submit" value="Change Name" name="change_name_btn">
									</form>
								</section></a>
								
								<section class="box style1">
									<form action="editProfile.php" method="post">
									<h2>Change your password</h2>
									<input type="password" name="OldPassword" placeholder="Please enter your current password">
									<input type="password" name="NewPassword1" placeholder="Please enter your new password">
									<input type="password" name="NewPassword2" placeholder="Please enter your new password again">
									<input type="submit" value="Change Password" name="change_password_btn">
									</form>
								</section></a>
							
								<section class="box style1">
									<form action="editProfile.php" method="post">
									<h2>Change your email address</h2>
									<input type="text" name="NewEmail" placeholder="Please enter your new email address">
									<input type="submit" value="Change Email" name="change_email_btn">
									</form>
								</section></a>
								
								<a href="./profilePage.php" class="button small">Back</a>
							
							
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
		
	