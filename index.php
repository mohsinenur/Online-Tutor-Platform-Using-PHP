<?php
 include ( "inc/connection.inc.php" );

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
		  
		</div>
		<div class="topnav">
			<div class="parent2">
		  <div class="test1 bimage1"><a href=""><img src="image/tech.png" title="IT Solution" style="border-radius: 50%;" width="42" height="42"></a></div>
		  <div class="test2"><a href="#"><img src="image/eventmgt.png" title="Event Management" width="42" height="42" style="border-radius: 50%;"></a></div>
		  <div class="test3"><a href="#"><img src="image/photography.png" title="Photography" width="42" height="42" style="border-radius: 50%;"></a></div>
		  <div class="test4"><a href="#"><img src="image/teaching.png" title="Tution" style="border-radius: 50%;" width="42" height="42"></a></div>
		  <div class="mask2"><i class="fa fa-home fa-3x"></i></div>
		</div>
			<a class="active navlink" href="index.php" style="margin: 0px 0px 0px 100px;">Newsfeed</a>
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
	<div class="nbody" style="margin: 0px 100px; overflow: hidden;">
		<div class="nfeedleft">


				<?php
					$todaydate = date("m/d/Y"); //Month/Day/Year 12/20/2017

					$query = $con->query("SELECT * FROM post ORDER BY id DESC");
					while ($row = $query->fetch_assoc()) {
						$post_id = $row['id'];
						$postby_id = $row['postby_id'];
						$sub = $row['subject'];
						$sub = str_replace(",", ", ", $sub);
						$class = $row['class'];
						$class = str_replace(",", ", ", $class);
						$salary = $row['salary'];
						$location = $row['location'];
						$location = str_replace(",", ", ", $location);
						$p_university = $row['p_university'];
						$post_time = $row['post_time'];
						$deadline = $row['deadline'];
						$medium = $row['medium'];
						$medium = str_replace(",", ", ", $medium);

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

								}else {
									if((strtotime($deadline) - strtotime($todaydate)) < 0){
										echo '
										<input type="submit" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Deadline Over" />';
									}else{
										$resultpostcheck = $con->query("SELECT * FROM applied_post WHERE post_id='$post_id' AND applied_by='$user'");
											$query_apply_cnt = $resultpostcheck->num_rows;
											if($query_apply_cnt > 0){
												echo '
											<input type="button" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Already Applied" />';
											}else{
											echo '<form action="viewpost.php?pid='.$post_id.'" method="post">
									<input type="submit" class="sub_button" style="margin: 0px;" name="" value="Apply" />
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
								<h5 style="color: #757575;"><a class="c_ptime" href="viewpost.php?pid='.$post_id.'">'.$time->time_ago($post_time).'</a> &nbsp;|&nbsp; Deadline: '.$deadline.'</h5>
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
	

</div>
<!-- main jquery script -->
<script  src="js/jquery-3.2.1.min.js"></script>

<!-- homemenu tab script -->
<script  src="js/homemenu.js"></script>

<!-- topnavfixed script -->
<script  src="js/topnavfixed.js"></script>

</body>
</html>
