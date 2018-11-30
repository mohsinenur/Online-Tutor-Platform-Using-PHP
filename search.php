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


//declearing variable
$f_loca = "";
$f_class = "";
$f_dead = "";
$f_sal = "";
$f_sub = "";
$f_uni = "";
$f_medi = "";


//$f_sub = $_POST['sub_list'];

//get sub list
include_once("inc/listclass.php");
$list_check = new checkboxlist();
?>



<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
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
			<a class="navlink" href="index.php" style="margin: 0px 0px 0px 100px;">Newsfeed</a>
			<a class="active navlink" href="search.php">Search Tutor</a>
			<?php 
			if($utype_db == "teacher")
				{

				}else {
					echo '<a class=" navlink" href="postform.php">Post</a>';
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
		<div class="nfeedleftsearch">
			<div class="postbox">
			<h3>Search Tutor</h3>
			<?php
				echo '<div class="signup_error_msg">';
					
						if (isset($error_message)) {echo $error_message;}
						
					
				echo'</div>';
				?>
			  	<form method="post">
			  		<div class="itemrow">
			  			<div style="width: 25%; float: left;">
			  				<label>Subject: </label>
			  			</div>
			  			<div style="width: 75%; float: left;">
			  				<?php $list_check->sublistcombo(); ?>
			  			</div>
			  		</div>
			  	
				
					<div class="itemrow">
						<div style="width: 25%; float: left;">
							<label>Class: </label>
						</div>
						<div style="width: 75%; float: left;">
							<?php $list_check->classlistcombo(); ?>
						</div>
						
					</div>
				  	<div class="itemrow">
				  			<div style="width: 25%; float: left;">
				  				<label>Medium: </label>
				  			</div>
				  			<div style="width: 75%; float: left;">
							<?php $list_check->mediumlistcombo(); ?>
						</div>
					</div>
					<div class="itemrow">
				  			<div style="width: 25%; float: left;">
				  				<label>Salary Range: </label>
				  			</div>
							<div style="width: 75%; float: left;">
								<select name="sal_range" style="width: 180px;">
									<?php if($f_sal!="") echo '<option value="'.$f_sal.'">'.$f_sal.'</option>';  ?>
								  <option value="None">None</option>
								  <option value="1000-2000">1000-2000</option>
								  <option value="2000-5000">2000-5000</option>
								  <option value="5000-10000">5000-10000</option>
								  <option value="10000-15000">10000-15000</option>
								  <option value="15000-25000">15000-25000</option>
								</select>
							</div>
						</div>
				  	<div class="itemrow">
				  			<div style="width: 25%; float: left;">
				  				<label>Location: </label>
				  			</div>
				  			<div style="width: 75%; float: left;" >
				  				<?php echo '<input type="text" style="width: 174px;" name="location" value="'.$f_loca.'" placeholder="e.g: Nikunja 2, Banani">'; ?>
				  			</div>
				  		</div>
					<div class="itemrow">
				  			<div style="width: 25%; float: left;">
				  				<label>University: </label>
				  			</div>
							<div style="width: 75%; float: left;">
								<select name="p_university" style="width: 180px;">
								<?php if($f_uni!="") echo '<option value="'.$f_uni.'">'.$f_uni.'</option>';  ?>
							  <option value="None">None</option>
							  <option value="Southeast University">Southeast University</option>
							  <option value="Brac University">Brac University</option>
							  <option value="Dhaka Univesity">Dhaka Univesity</option>
							</select>
							</div>
						</div>
					<input type="submit" name="submit" class="sub_button" value="Search"/></br></br>
				</form>
			</div>
		</div>
		<div class="nfeedrightsearch">
			<?php
				if (isset($_POST['submit'])){
					$f_sub = $_POST['sublistcombo'];
					$f_sub = mysqli_real_escape_string($con, $f_sub);
					$f_class = $_POST['classlistcombo'];
					$f_class = mysqli_real_escape_string($con, $f_class);
					$f_medium = $_POST['mediumlistcombo'];
					$f_medium = mysqli_real_escape_string($con, $f_medium);
					$f_sal = $_POST['sal_range'];
					$f_sal = mysqli_real_escape_string($con, $f_sal);
					$f_loca = $_POST['location'];
					$f_loca = mysqli_real_escape_string($con, $f_loca);
					$f_university = $_POST['p_university'];
					$f_university = mysqli_real_escape_string($con, $f_university);


					//if(($f_class && $f_medium && $f_sal && $f_loca && $f_university) == ""){
					//	$query_sub = $con->query("SELECT * FROM tutor WHERE prefer_sub LIKE '%{$f_sub}%' ORDER BY id DESC ");
					//}

					$condition = '1=1';

					if ($f_sub != "None"){
					    $condition = $condition . " AND prefer_sub LIKE '%{$f_sub}%' ";
					} 

					if ($f_class != "None"){
					    $condition =  $condition . " AND class LIKE '%{$f_class}%' ";
					} 

					if ($f_medium != "None"){
					    $condition =  $condition . " AND medium LIKE '%{$f_medium}%' ";
					} 

					if ($f_sal != "None"){
					    $condition =  $condition . " AND salary LIKE '%{$f_sal}%' ";
					}

					if ($f_loca != ""){
					    $condition =  $condition . " AND prefer_location LIKE '%{$f_loca}%' ";
					} 

					if ($f_university != "None"){
					    $condition =  $condition . " AND inst_name LIKE '%{$f_university}%' ";
					} 

				
					if($condition == "1=1"){
						echo '
						<div class="nfbody">
						<div class="p_body">
							<div class="itemrow" style="text-align: center;">
					  				<p><label>Please Select Search Item</label></p>
					  		</div>
						</div>
					</div>

					';
					}else{
						$query_sub = $con->query("SELECT * FROM `tutor` WHERE ".$condition);
						$query_sub_cnt = $query_sub->num_rows;
						if($query_sub_cnt == 0){
							$query_sub_cnt = "No";
						}
						echo '
						<div class="nfbody">
						<div class="p_body">
							<div class="itemrow" style="text-align: center;">
					  				<p><label>'.$query_sub_cnt.' Tutor Found </label></p>
					  		</div>
						</div>
					</div>';
					
					while($row = $query_sub->fetch_assoc()) { 
						$post_id = $row['id'];
						$tutor_id = $row['t_id'];
						$sub = $row['prefer_sub'];
						$sub = str_replace(",", ", ", $sub);
						$class = $row['class'];
						$class = str_replace(",", ", ", $class);
						$salary = $row['salary'];
						$location = $row['prefer_location'];
						$location = str_replace(",", ", ", $location);
						$p_university = $row['inst_name'];
						$medium = $row['medium'];

						$query1 = $con->query("SELECT * FROM user WHERE id='$tutor_id'");
						$user_fname = $query1->fetch_assoc();
						$uname_db = $user_fname['fullname'];
						$pro_pic_db = $user_fname['user_pic'];
						$ugender_db = $user_fname['gender'];
						$last_login = $user_fname['last_logout'];
						$cntnm = "";
						if($user != ""){
							$query6 = $con->query("SELECT * FROM applied_post WHERE applied_by='$user' AND applied_to='$tutor_id'");
							$cntnm = $query6->num_rows;
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

									if($cntnm > 0){
										echo '
									<input type="button" class="sub_button" style="margin: 0px; background-color: #a76d6d;" name="" value="Selected" />
								';
									}elseif($user == $tutor_id){
										
									}else{
										echo '<form action="confirmteacher.php?confirm='.$tutor_id.'" method="post">
									<input type="submit" class="sub_button" style="margin: 0px;" name="post_apply" value="Select" />
								</form>';
									}

							echo '</div>
							<div>
								<img src="image/profilepic/'.$pro_pic_db.'" width="41px" height="41px">
							</div>
							<div class="p_nmdate">
								<h4>'.$uname_db.'</h4>
								<h5 style="color: #757575;"><a class="c_ptime" href="viewpost.php?pid='.$post_id.'">Active '.$time->time_ago($last_login).'</a></h5>
							</div>
						</div>
						<div class="p_body">
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<p><label>Teaches: </label></p>
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
					  				<label>Area: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$location.'</span>
					  			</div>
					  		</div>
							<div class="itemrow">
					  			<div class="itemrowdiv1">
					  				<label>University: </label>
					  			</div>
					  			<div class="itemrowdiv2">
					  				<span>'.$p_university.'</span>
					  			</div>
					  		</div>
						</div>
					</div>';

					}
				}

				}
			?>
		</div>
	</div>
	<!-- footer -->

</div>

<!-- main jquery script -->
<script  src="js/jquery-3.2.1.min.js"></script>

<!-- homemenu tab script -->
<script  src="js/homemenu.js"></script>

<!-- topnavfixed script -->
<script  src="js/topnavfixed.js"></script>

<!-- topnavfixed script -->
<script  src="js/nfeedleftsearchfixed.js"></script>



</body>
</html>