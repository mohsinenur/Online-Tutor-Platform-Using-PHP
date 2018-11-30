<?php

$con = new mysqli('localhost', 'root', '', 'main_db');

if($con->connect_errno > 0){
    die('Unable to connect to database [' . $con->connect_error . ']');
}

?>
<?php 

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: index.php");
}
else {
	$user = $_SESSION['user_login'];
	$result = $con->query("SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);

			$uname_db = $get_user_email['fullname'];
			$uemail_db = $get_user_email['email'];
			$utype_db = $get_user_email['type'];
}

if (isset($_REQUEST['uid'])) {
	$user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
	if($user != $user2){
		header('location: index.php');
	}
}else {
	header('location: index.php');
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
	<!-- menu tab link -->
	<link rel="stylesheet" type="text/css" href="css/homemenu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	
</head>
<body class="body1">
<div>
	<div>
		<header class="header">

			<div class="header-cont">

				<?php
					include 'inc/banner.inc.php';
				?>

			</div>
		</header>
		<div class="w3-sidebar w3-bar-block w3-collapse w3-card-2 w3-animate-left" stylRe="width:100px;" id="mySidebar">
		  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
		  <a href="index.php" class="w3-bar-item w3-button">Tution</a>
		  <a href="photography.php" class="w3-bar-item w3-button">Photography</a>
		  <a href="#" class="w3-bar-item w3-button">IT</a>
		</div>
		<div class="topnav">
			<div class="parent2">
		  <div class="test1 bimage1"><a href=""><img src="image/tech.png" title="IT Solution" style="border-radius: 50%;" width="42" height="42"></a></div>
		  <div class="test2"><a href="#"><img src="image/eventmgt.png" title="Event Management" width="42" height="42" style="border-radius: 50%;"></a></div>
		  <div class="test3"><a href="#"><img src="image/photography.png" title="Photography" width="42" height="42" style="border-radius: 50%;"></a></div>
		  <div class="test4"><a href="#"><img src="image/teaching.png" title="Tution" style="border-radius: 50%;" width="42" height="42"></a></div>
		  <div class="mask2"><i class="fa fa-home fa-3x"></i></div>
		</div>
			<a class="navlink" href="index.php" style="margin: 0px 0px 0px 100px;">Newsfeed</a>
			<a class="navlink" href="search.php">Search Tutor</a>
			<?php 
			if($utype_db == "teacher")
				{

				}else {
					echo '<a class="navlink" href="postform.php">Post</a>';
				}

			 ?>
			<a class="navlink" href="#contact">Contact</a>
			<a class="navlink" href="#about">About</a>
			<div style="float: right;" >
				<table>
					<tr>
						<?php
							if($user != ""){
								$resultnoti = $con->query("SELECT * FROM applied_post WHERE post_by='$user' AND student_ck='no'");
								$resultnoti_cnt = $resultnoti->num_rows;
								if($resultnoti_cnt == 0){
									$resultnoti_cnt = "";
								}else{
									$resultnoti_cnt = '('.$resultnoti_cnt.')';
								}
								echo '<td>
							<a class="navlink" href="notification.php">Notification'.$resultnoti_cnt.'</a>
						</td>
								<td>
							<a class="navlink" href="profile.php?uid='.$user.'">'.$uname_db.'</a>
						</td>
						<td>
							<a class="navlink" href="logout.php">Logout</a>
						</td>';
							}else{
								echo '<td>
							<a class="navlink" href="login.php">Login</a>
						</td>
						<td>
							<a class="navlink" href="registration.php">Register</a>
						</td>';
							}
						?>
						
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- newsfeed -->
	<div style="margin: 20px; overflow: hidden;">
		<div style="width: 1000px; margin: 0 auto;">
		
			<ul>
				<li style="float: left;">
					<div class="settingsleftcontent">
						<ul>
							<li><?php echo '<a href="profile.php?uid='.$user.'" style=" background-color: #4CAF50;; border-radius: 4px; color: #fff;" >Post</a>'; ?></li>
							<li><?php echo '<a href="aboutme.php?uid='.$user.'" >About</a>'; ?></li>
							<li><?php echo '<a href="settings.php">Settings</a>'; ?></li>
						</ul>
					</div>
				</li>
				<li style="float: right;">
					<div class="holecontainer">
						<?php
					$query = $con->query("SELECT * FROM post WHERE postby_id='$user' ORDER BY id DESC");
					$num1 = mysqli_num_rows($query);
					if($num1 == 0){
						echo '
						<div class="p_bodyn">
							<p>No post found !!!</p>
						</div>
					</div>';
					}
					while ($row = $query->fetch_assoc()) {
						$post_id = $row['id'];
						$postby_id = $row['postby_id'];
						$sub = $row['subject'];
						$class = $row['class'];
						$salary = $row['salary'];
						$location = $row['location'];
						$p_university = $row['p_university'];
						$post_time = $row['post_time'];
						$deadline = $row['deadline'];
						$medium = $row['medium'];	

						$query1 = $con->query("SELECT * FROM user WHERE id='$postby_id'");
						$user_fname = $query1->fetch_assoc();
						$uname_db = $user_fname['fullname'];
						$pro_pic_db = $user_fname['user_pic'];
						$ugender_db = $user_fname['gender'];

						if($pro_pic_db == ""){
								if($ugender_db == "male"){
								$pro_pic_db = "malepic.png";
							}else if($ugender_db == "female"){
								$pro_pic_db = "femalepic.png";

							}
						}else {
							if (file_exists("image/profilepic/".$pro_pic_db)){
							//nothing
							}else{
									if($ugender_db == "male"){
									$pro_pic_db = "malepic.png";
								}else if($ugender_db == "female"){
									$pro_pic_db = "femalepic.png";

								}
							}
						}

						echo '
							<div class="nfbody">
							<div class="p_head">
							<div>
								<a href="editpost.php?pid='.$post_id.'" style="float: right; color: #aaa; font-weight: bold;"><img src="image/edit.png" height="25" width="25" ></a>
							</div>
							<div>
								<img src="image/profilepic/'.$pro_pic_db.'" width="41px" height="41px">
							</div>
							<div class="p_nmdate">
								<h4>'.$uname_db.'</h4>
								<h5 style="color: #757575;">'.$time->time_ago($post_time).' &nbsp;|&nbsp; Deadline: '.$deadline.'</h5>
							</div>
						</div>
						<div class="p_body">
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<p><label>Subject: </label></p>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$sub.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Class: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$class.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Medium: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$medium.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Salary: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$salary.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Location: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$location.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>Preferred University: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$p_university.'</span>
					  			</div>
					  		</div>
						</div>
					</div>';

					}
				?>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- footer -->
	<div>
	<?php
		include 'inc/footer.inc.php';
	?>
	</div>

	




</div>
 <!-- homemenu tab script -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="js/homemenu.js"></script>
</body>
</html>