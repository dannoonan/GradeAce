<?php
	
	session_start();
	
	require_once('load.php');
	
	
	if (isset($_POST['create_btn'])){
		$Title=($_POST['Title']);
		$TaskType=($_POST['TaskType']);
		$Description=($_POST['Description']);
		$Pages=($_POST['Pages']);
		$Words=($_POST['Words']);
		$FileFormat=($_POST['FileFormat']);
		$ClaimDate=($_POST['ClaimDate']);
		$CompleteDate=($_POST['CompleteDate']);
		
		$FilePath=('f');	//For now just to have all details
			
		$sql = "INSERT INTO tasks(Title, TaskType, Description, Pages, Words, FileFormat, FilePath, ClaimDate, CompleteDate) VALUES('$Title', '$TaskType', '$Description', '$Pages', '$Words', '$FileFormat', '$FilePath', '$ClaimDate', '$CompleteDate')";
		mysqli_query($db, $sql);
				
		$TaskId = mysqli_insert_id($db)or die(mysqli_error($db));
		
		for($i=0; $i<4; $i++)
		{
			$cont=false;
			if($i==0 && !(empty($_POST['Tag1'])))
			{
				$Tag=($_POST['Tag1']);
				$cont=true;
			}
			else if($i==1 && !(empty($_POST['Tag2'])))
			{
				$Tag=($_POST['Tag2']);
				$cont=true;
			}
			else if ($i==2 && !(empty($_POST['Tag3'])))
			{
				$Tag=($_POST['Tag3']);
				$cont=true;
			}
			else if ($i==3 && !(empty($_POST['Tag4'])))
			{
				$Tag=($_POST['Tag4']);
				$cont=true;
			}
			
			if($cont == TRUE)
			{
				$Query = "Select Tag from tags where Tag = '$Tag' ";
				if($result = mysqli_query($db, $Query)) {
				if ( $result===NULL || mysqli_num_rows($result) == 0 ) {					
					mysqli_query($db, "INSERT INTO tags(Tag) VALUES('$Tag')");
					$TagId = mysqli_insert_id($db)or die(mysqli_error($db));
					mysqli_query($db,"INSERT INTO tasktags(TaskId, TagId) Values ('$TaskId', '$TagId')");
				} else {
					$GetTagId=mysqli_query($db, "SELECT TagId FROM tags WHERE Tag='$Tag'");
					$GetTagId = mysqli_fetch_array($GetTagId);
					$TagId=$GetTagId['TagId'];
					mysqli_query($db,"INSERT INTO tasktags(TaskId, TagId) Values ('$TaskId', '$TagId')");
				}
				} else {
					echo "Query failed ". $Query;
				}
			}
		}
		
		mysqli_query($db,"INSERT INTO flag(TaskId, IsFlagged) Values ('$TaskId', 'false')");
		mysqli_query($db,"INSERT INTO statustable(TaskId) Values ('$TaskId')");
		
		$userId = $_SESSION['id'];
		mysqli_query($db,"INSERT INTO owned(UserId, TaskId) Values ('$userId', '$TaskId')");
				
		//header("location: index.php");
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
					<li><a href="#login">Login</a></li>
					<li><a href="#register">Register</a></li>
					<li><a href="#portfolio">About</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</nav>

		<!-- Home -->
			<div class="wrapper style1 first">
				<article class="container" id="login">
					<div class="row">
						
						<div class="8u 12u(mobile)">
							<header>
								<h1>Task Creation.</h1>
								<h2>Create a Task by filling in the details below.</h2>
							</header>
							
							<form action="CreateTask.php" method="post">
							
							<input type="text" name="Title" placeholder="Please enter the task title.">
							<select name="TaskType">
								<option value="">Select your task type...</option>
								<option value="Thesis">MSc Thesis</option>
								<option value="Dissertation">BSc Dissertation</option>
								<option value="Report">Project Report</option>
								<option value="Thesis">PhD Thesis</option>
								<option value="Assignment">Assignment</option>
								<option value="CRP">Conference Research Paper</option>
							</select>
							<input type="text" name="Description" placeholder="Please enter the task description.">
							<input type="text" name="Tag1" placeholder="(Optional)Please enter a tag.">
							<input type="text" name="Tag2" placeholder="(Optional)Please enter a tag.">
							<input type="text" name="Tag3" placeholder="(Optional)Please enter a tag.">
							<input type="text" name="Tag4" placeholder="(Optional)Please enter a tag.">
							Please enter the page length of the task:	<input type="number" name="Pages">
							</br>Please enter the word count of the task:	<input type="number" name="Words">							
							<select name="FileFormat">
								<option value="">Select your file format...</option>
								<option value="pdf">PDF</option>
								<option value="docx">Docx</option>
								<option value="doc">Doc</option>
								<option value="Open Office">Open Office</option>
								<option value="txt">Txt</option>
								<option value="odt">Odt</option>
							</select>
							Please choose 3 pdf pages at random from your task to upload
							</br><input type="file" name="pdf1" />
							</br><input type="file" name="pdf2" />
							</br><input type="file" name="pdf3" />
							
							</br>Please enter the date by which the task must be claimed:	<input type="date" name="ClaimDate">
							</br>Please enter the date by which the task must be completed:		<input type="date" name="CompleteDate">
							<input type="submit" value="Create Task" name="create_btn">
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