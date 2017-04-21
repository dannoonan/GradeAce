<?php
	 require_once __DIR__.'/daos/TaskDAO.class.php';   
	 require_once __DIR__.'/daos/FileDAO.class.php';  
	 require_once __DIR__.'/daos/UserDAO.class.php'; 	 
	 require_once __DIR__.'/models/User.class.php';
	 require_once __DIR__.'/models/PdfFile.class.php';
	 require_once __DIR__.'./utils/MySQLiAccess.class.php';

	
	session_start();
	
	require_once('load.php');
	
	//when Create task button pressed to submit the form
	if (isset($_POST['create_btn'])){
	
		if(($_FILES['pdf1']['size'] > 0))
		{
			
			//Takes in all information given
			$Title=($_POST['Title']);
			$TaskType=($_POST['TaskType']);
			$CurrentTaskField=($_POST['TaskField']);
			$Description=($_POST['Description']);
			$Pages=($_POST['Pages']);
			$Words=($_POST['Words']);
			$FileFormat=($_POST['FileFormat']);
			$ClaimDate=($_POST['ClaimDate']);
			$CompleteDate=($_POST['CompleteDate']);
			
		
			$Title2 = mysqli_real_escape_string($db, $Title);
			$Description2 = mysqli_real_escape_string($db, $Description);
			
			
			
			//ensures all relevant information is given
		if(empty($Title) || empty($TaskType) || empty($Description) || empty($Pages) || empty($Words) ||
			empty($FileFormat) || empty($ClaimDate) || empty($CompleteDate))
			{
				echo "Error!! Information missing";
			}
			else
			{
				$TaskDAO=new TaskDAO();
				$FileDAO=new FileDAO();
				
				//creates information for uploading pdf to database
				$fileName = $_FILES['pdf1']['name'];
				$tmpName  = $_FILES['pdf1']['tmp_name'];
				$fileSize = $_FILES['pdf1']['size'];
				$fileType = $_FILES['pdf1']['type'];
				
			$fp      = fopen($tmpName, 'r');
			$content = fread($fp, filesize($tmpName));
			$content = addslashes($content);
			fclose($fp);

			if(!get_magic_quotes_gpc())
			{
				$fileName = addslashes($fileName);
			}

			//stores pdf in Upload table in databse
			$query = "INSERT INTO upload (fileName, fileSize, fileType, content) VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
			
			mysqli_query($db, $query) or die('Error, query failed'); 
			$FilePath=mysqli_insert_id($db)or die(mysqli_error($db));
			
			if (isset($_SESSION["UserId"]) && $_SESSION["UserId"] != ''){
				$userId = $_SESSION['UserId'];
			}

			$user=new user();
			$userDAO=new UserDAO();
			$user=$userDAO->getUser($userId,'');
			$TaskField=$user->getCourse();
			
			//adds task details to task table in database
			$sql = "INSERT INTO tasks(Title, TaskType, TaskField, Description, Pages, Words, FileFormat, FilePath, ClaimDate, CompleteDate) VALUES('$Title2', '$TaskType', '$CurrentTaskField', '$Description2', '$Pages', '$Words', '$FileFormat', '$FilePath', '$ClaimDate', '$CompleteDate')";
			mysqli_query($db, $sql);
				
			$TaskId = mysqli_insert_id($db)or die(mysqli_error($db));
			
			//see's if tags are being added
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
			
				//checks if tags already exist in the database and if not adds them
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
		
			//adds relevant data tp flag, statustable and owned tables
			mysqli_query($db,"INSERT INTO flag(TaskId) Values ('$TaskId')");
			mysqli_query($db,"INSERT INTO statustable(TaskId) Values ('$TaskId')");
			
			$userId = $_SESSION['UserId'];
			mysqli_query($db,"INSERT INTO owned(UserId, TaskId) Values ('$userId', '$TaskId')");
					
			header("location: index.php");
		}
	}
	else
		echo "NO PDF UPLOADED";
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
								<h1>Task Creation.</h1>
								<h2>Create a Task by filling in the details below.</h2>
							</header>
							<!-- Create task form where information is entered -->
							<form action="CreateTask.php" method="post" enctype="multipart/form-data">
							
							<input type="text" name="Title" placeholder="*Please enter the task title.">
							<select name="TaskType">
								<option value="">*Select your task type...</option>
								<option value="MA Thesis">MA Thesis</option>
								<option value="BA Dissertation">BA Dissertation</option>
								<option value="MSc Thesis">MSc Thesis</option>
								<option value="BSc Dissertation">BSc Dissertation</option>
								<option value="Report">Project Report</option>
								<option value="Thesis">PhD Thesis</option>
								<option value="Assignment">Assignment</option>
								<option value="CRP">Conference Research Paper</option>
							</select>
							<select name="TaskField">
								<option value="">*Select the field of study to which your task belongs...</option>
								<option value="Computing">Computing</option>
								<option value="Engineering">Engineering</option>
								<option value="Humanities">Humanities</option>
								<option value="Business">Business</option>
								<option value="Science">Science</option>
								<option value="Medicine">Medicine</option>
								<option value="Law">Law</option>
							</select>
							<input type="text" name="Description" placeholder="*Please enter the task description.">
							<input type="text" name="Tag1" placeholder="(Optional)Please enter a tag.">
							<input type="text" name="Tag2" placeholder="(Optional)Please enter a tag.">
							<input type="text" name="Tag3" placeholder="(Optional)Please enter a tag.">
							<input type="text" name="Tag4" placeholder="(Optional)Please enter a tag.">
							*Please enter the page length of the task:	<input type="number" name="Pages">
							</br>*Please enter the word count of the task:	<input type="number" name="Words">							
							<select name="FileFormat">
								<option value="">*Select your file format...</option>
								<option value="pdf">PDF</option>
								<option value="docx">Docx</option>
								<option value="doc">Doc</option>
								<option value="Open Office">Open Office</option>
								<option value="txt">Txt</option>
								<option value="odt">Odt</option>
							</select>
							*Please choose 3 pages at random from your task you wish to show and upload as a pdf
							</br><input type="file" name="pdf1" />
							
							</br>*Please enter the date by which the task must be claimed:	<input type="date" name="ClaimDate">
							</br>*Please enter the date by which the task must be completed:		<input type="date" name="CompleteDate">
							</br></br>(Note all fields marked with * need to be filled)</br>
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