<?php
$con = new mysqli('localhost', 'root', '', 'main_db');

if($con->connect_errno > 0){
    die('Unable to connect to database [' . $con->connect_error . ']');
}

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
	$utype_db = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = $con->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

//time ago convert
include_once("inc/timeago.php");
$time = new timeago();

if (isset($_REQUEST['pid'])) {
	$pstid = mysqli_real_escape_string($con, $_REQUEST['pid']);
}else {
	header('location: index.php');
}

//apply post
if (isset($_POST['post_apply'])) {
	if($user == ''){
		$_SESSION['apply_post'] = "".$pstid."";
		header("Location: login.php?pid=".$pstid."");
	}else{
		$resultpost = $con->query("SELECT * FROM post WHERE id='$pstid'");
		$get_user_name = $resultpost->fetch_assoc();
			$postby_id = $get_user_name['postby_id'];

		$result = mysqli_query($con, "INSERT INTO applied_post (`post_id`,`post_by`,`applied_by`,`applied_to`) VALUES ('".$pstid."','".$postby_id."','".$user."','".$postby_id."')");

		if($result){
			header("Location: viewpost.php?pid=".$pstid."");
		}else{
			echo "Could not apply!";
		}
	}
}

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
		<div class="topnav">
			<div class="parent2">
		  <div class="test1 bimage1"><a href=""><img src="image/tech.png" title="IT Solution" style="border-radius: 50%;" width="42" height="42"></a></div>
		  <div class="test2"><a href="#"><img src="image/eventmgt.png" title="Event Management" width="42" height="42" style="border-radius: 50%;"></a></div>
		  <div class="test3"><a href="#"><img src="image/photography.png" title="Photography" width="42" height="42" style="border-radius: 50%;"></a></div>
		  <div class="test4"><a href="#"><img src="image/teaching.png" title="Tution" style="border-radius: 50%;" width="42" height="42"></a></div>
		  <div class="mask2"><i class="fa fa-home fa-3x"></i></div>
		</div>
			<a class="active navlink" href="index.php" style="margin: 0px 0px 0px 100px;">Newsfeed</a>
			<a class="navlink" href="#news">Search Tutor</a>
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
								echo '<td>
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
	<div class="nbody" style="margin: 0px 100px; overflow: hidden;">
		<div class="nfeedleft">

				<?php
					$todaydate = date("m/d/Y"); //Month/Day/Year 12/20/2017

					$query = $con->query("SELECT * FROM post WHERE id= '$pstid'");
					while ($row = $query->fetch_assoc()) {
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
							<div style="float: right;">';
								if($user!='' && $utype_db=='student'){
										echo "<span style='color: red;'>Only teacher can apply!</span>";
								}else {
									if((strtotime($deadline) - strtotime($todaydate)) < 0){
										echo '
										<input type="submit" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Deadline Over" />';
									}else{
										$resultpostcheck = $con->query("SELECT * FROM applied_post WHERE post_id='$pstid' AND applied_by='$user'");
											$query_apply_cnt = $resultpostcheck->num_rows;
											if($query_apply_cnt > 0){
												echo '
											<input type="button" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Already Applied" />';
											}else{
											echo '<form action="" method="post">
											<input type="submit" class="sub_button" style="margin: 0px;" name="post_apply" value="Confirm Apply" />
										</form>';
												}
										
									}
								}
							echo '</div>
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
		<div class="nfeedright">
			
		</div>
	</div>
	<!-- footer -->
	<div>
	<?php
		include 'inc/footer.inc.php';
	?>
	</div>

</div>
<!-- home menu tab -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script  src="js/homemenu.js"></script>
</body>
</html>