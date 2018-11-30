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

	$rslttution = $con->query("SELECT * FROM applied_post WHERE (post_by='$user2' AND applied_by='$user' AND tution_cf='1') OR applied_by='$user2' AND applied_to='$user'");

	$cnt_rslttution = $rslttution->num_rows;

	
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
							<a class="active navlink" href="profile.php?uid='.$user.'">'.$uname_db.'</a>
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
				<?php 
						if($user == $user2){
							echo '<li style="float: left;">
					<div class="settingsleftcontent">
						<ul>
							<li><a href="profile.php?uid='.$user.'" >Post</a></li>
							<li><a href="aboutme.php?uid='.$user.'" style=" background-color: #4CAF50;; border-radius: 4px; color: #fff;" >About</a></li>
							<li><a href="settings.php">Settings</a></li>
						</ul>
					</div>
					</li>';
						}else{

						}
					?>
					
				<?php
					if($user == $user2){
						echo '<li style="float: right;">';
					}else{
						echo '<li style="float: left;">';
					}
				 ?>
				
					<?php

						$query1 = $con->query("SELECT * FROM user WHERE id='$user2'");
						$user_fname = $query1->fetch_assoc();
						$uname_db = $user_fname['fullname'];
						$pro_pic_db = $user_fname['user_pic'];
						$ugender_db = $user_fname['gender'];
						$uemail_db = $user_fname['email'];
						$uphone_db = $user_fname['phone'];
						$ugender_db = $user_fname['gender'];
						$uaddress_db = $user_fname['address'];
						$utype_db = $user_fname['type'];

						$query2 = $con->query("SELECT * FROM tutor WHERE t_id='$user2' ORDER BY id DESC");
						$tutor_info = $query2->fetch_assoc();
						$uinsname_db = $tutor_info['inst_name'];
						$umedium_db = $tutor_info['medium'];
						$usalrange_db = $tutor_info['salary'];
						$uclass_db = $tutor_info['class'];
						$upresub_db = $tutor_info['prefer_sub'];
						$upreloca_db = $tutor_info['prefer_location'];

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
						<div class="holecontainer">
						<div class="nfbody">
						<div class="p_body">';
							if($user == $user2){
								echo '<div>
								<a href="updateinfo.php" style="float: right; color: #aaa; font-weight: bold;"><img src="image/edit.png" height="25" width="25" ></a>
							</div>';
							}
						
							echo '<div class="" style="text-align: center;">';
								if (file_exists('image/profilepic/'.$pro_pic_db.'')){
									echo '<img src="image/profilepic/'.$pro_pic_db.'" class="home-prodlist-imgi">';
								}else {
									
									echo'<div class="home-prodlist-imgi" style="text-align: center; padding: 0 0 6px 0;">No Image Found!</div>';
								}
							echo '</div><h4 style="text-align: center; font-size: 12px;">Account Type: '.ucfirst($utype_db).'</h4>
							<h2 style="text-align: center;">Personal Informaion</h2>
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Name: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$uname_db.'</span>
					  			</div>
				  			</div>';
				  			if(($user==$user2) || ($cnt_rslttution>=1)){
				  				echo '<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Email: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$uemail_db.'</span>
					  			</div>
				  			</div> 
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Phone: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$uphone_db.'</span>
					  			</div>
				  			</div>
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Address: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$uaddress_db.'</span>
					  			</div>
				  			</div>';
				  			}
							echo '<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Gender: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.ucfirst($ugender_db).'</span>
					  			</div>
				  			</div> ';
								if($utype_db == "student"){

								}else if($utype_db == "teacher"){
									echo '<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Institute: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$uinsname_db.'</span>
					  			</div>
				  			</div>';
								}
							 echo'</div></div>';
							if($utype_db == "student")
							{

							}else if($utype_db == "teacher"){
								echo '<div class="nfbody">
						<div class="p_body">';
							if($user == $user2){
								echo '<div>
								<a href="updatetutioninfo.php?uid='.$user.'" style="float: right; color: #aaa; font-weight: bold;"><img src="image/edit.png" height="25" width="25" ></a>
							</div>';
							}
							echo '<h2 style="text-align: center;">Tution Informaion</h2>
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Medium: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$umedium_db.'</span>
					  			</div>
				  			</div>
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Class: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$uclass_db.'</span>
					  			</div>
				  			</div>
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Prefer Subject: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$upresub_db.'</span>
					  			</div>
				  			</div>
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Prefer Location: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$upreloca_db.'</span>
					  			</div>
				  			</div>
							<div class="itemrow">
					  			<div style="width: 20%; float: left;">
					  				<label>Expect Salary: </label>
					  			</div>
					  			<div style="width: 80%; float: left;">
					  				<span>'.$usalrange_db.'</span>
					  			</div>
				  			</div>
							';
							}
						echo '</div></div>
					</div>';
				?>
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