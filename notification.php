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

if($utype_db == "student"){
	$up = $con->query("UPDATE applied_post SET student_ck='yes'");
}
if($utype_db == "teacher"){
	$up = $con->query("UPDATE applied_post SET tutor_ck='yes'");
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
								if($utype_db == 'teacher'){
									$resultnoti = $con->query("SELECT * FROM applied_post WHERE (applied_by='$user' AND tution_cf='1' AND tutor_ck='no') OR (applied_to='$user' AND tutor_ck='no')" );
								}else{
									$resultnoti = $con->query("SELECT * FROM applied_post WHERE post_by='$user' AND student_ck='no'");
								}
								$resultnoti_cnt = $resultnoti->num_rows;
								if($resultnoti_cnt == 0){
									$resultnoti_cnt = "";
								}else{
									$resultnoti_cnt = '('.$resultnoti_cnt.')';
								}
								echo '<td>
							<a class="active navlink" href="notification.php">Notification'.$resultnoti_cnt.'</a>
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

					if($utype_db == 'teacher'){
						$query = $con->query("SELECT * FROM applied_post WHERE (applied_by='$user' AND tution_cf='1') OR (applied_to='$user') ORDER BY id DESC");
						$nmrow = $query->num_rows;
						if($nmrow == 0){
							echo '
								<div class="nfbody">
								<div class="p_head">
								<div class="p_nmdate">
									<h5>No Notification Found!</h5>
								</div>
							</div>
						</div>';
						}else{
						while ($row = $query->fetch_assoc()) {
							$post_id = $row['post_id'];
							$applied_by_id = $row['applied_by'];
							$post_by_id = $row['post_by'];
							$deadline = $row['applied_time'];
							$tution_confirm = $row['tution_cf'];

							if($post_by_id == 0) $post_by_id = $applied_by_id;

							$query1 = $con->query("SELECT * FROM user WHERE id='$post_by_id'");
							$user_fname = $query1->fetch_assoc();
							$uname_db = $user_fname['fullname'];
							$pro_pic_db = $user_fname['user_pic'];
							$ugender_db = $user_fname['gender'];

							if($post_id == ""){
								$notimsg = "applied on your tution! ";
							}else{
								$notimsg = "Choose you as tutor! ";
							}
						

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
										
												echo '<form action="aboutme.php?uid='.$post_by_id.'" method="post">
										<input type="submit" class="sub_button"  style="margin: 0px;" name="" value="View Contact" />
									</form>';
								echo '</div>
								<div>
									<img src="image/profilepic/'.$pro_pic_db.'" width="41px" height="41px">
								</div>
								<div class="p_nmdate">
									<h4><a href="aboutme.php?uid='.$post_by_id.'" style="color: #087E0D;">'.$uname_db.'</a> <span style="color: #626262; font-weight: 100;">'.$notimsg.'</span></h4>
									<h5 style="color: #757575;"><a class="c_ptime" >'.$time->time_ago($deadline).'</a></h5>
								</div>
							</div>
						</div>';



						}
						}
						
					}elseif($utype_db == 'student'){
						$query = $con->query("SELECT * FROM applied_post WHERE post_by='$user' ORDER BY id DESC");
						while ($row = $query->fetch_assoc()) {
							$post_id = $row['post_id'];
							$applied_by_id = $row['applied_by'];
							$deadline = $row['applied_time'];
							$tution_confirm = $row['tution_cf'];

							$query1 = $con->query("SELECT * FROM user WHERE id='$applied_by_id'");
							$user_fname = $query1->fetch_assoc();
							$uname_db = $user_fname['fullname'];
							$pro_pic_db = $user_fname['user_pic'];
							$ugender_db = $user_fname['gender'];

							if($post_id == ""){
								$notimsg = "applied on your tution ";
							}else{
								$notimsg = "want to teach you! ";
							}

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
										
											
												if($tution_confirm == "1"){
													echo '
												<input type="button" class="sub_button" style="margin: 0px; background-color: #a76d6d; cursor: default;" name="" value="Already Confirm" />';
												}else{
												echo '<form action="approvetutor.php?app_tut='.$post_id.'" method="post">
										<input type="submit" class="sub_button"  style="margin: 0px;" name="" value="Confirm" />
									</form>';
										}
								echo '</div>
								<div>
									<img src="image/profilepic/'.$pro_pic_db.'" width="41px" height="41px">
								</div>
								<div class="p_nmdate">
									<h4><a href="aboutme.php?uid='.$applied_by_id.'" style="color: #087E0D;">'.$uname_db.'</a> <span style="color: #626262; font-weight: 100;">'.$notimsg.'</span></h4>
									<h5 style="color: #757575;"><a class="c_ptime" href="viewpost.php?pid='.$post_id.'">'.$time->time_ago($deadline).'</a></h5>
								</div>
							</div>
						</div>';



						}
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
