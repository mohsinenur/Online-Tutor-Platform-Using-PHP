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

//declearing variable
$f_loca = "";
$f_class = "";
$f_dead = "";
$f_sal = "";
$f_sub = "";
$f_uni = "";
$f_medi = "";

if(isset($_SESSION['u_post']))
{
	$f_loca=$_SESSION['f_loca'];
	$f_dead=$_SESSION['f_dead'];
	$f_sal=$_SESSION['f_sal'];
	$f_uni=$_SESSION['f_uni'];
}


//posting
if (isset($_POST['submit'])) {

	$f_loca = $_POST['location'];
	$f_dead = $_POST['deadline'];
	$f_sal = $_POST['sal_range'];
	//$f_sub = $_POST['sub_list'];
	$f_uni = $_POST['p_university'];
	//create session for all field
	$_SESSION['f_loca'] = $f_loca;
	$_SESSION['f_class'] = $f_class;
	$_SESSION['f_dead'] = $f_dead;
	$_SESSION['f_sal'] = $f_sal;
	$_SESSION['f_uni'] = $f_uni;


	try {
		if(empty($_POST['sub_list'])) {
			throw new Exception('Subject can not be empty');
			
		}
		if(empty($_POST['class_list'])) {
			throw new Exception('Class can not be empty');
			
		}
		if(empty($_POST['medium_list'])) {
			throw new Exception('Medium can not be empty');
			
		}
		if(empty($_POST['sal_range'])) {
			throw new Exception('Salary range can not be empty');
			
		}
		if(empty($_POST['location'])) {
			throw new Exception('Location can not be empty');
			
		}
		if(empty($_POST['p_university'])) {
			throw new Exception('Preferred University can not be empty');
			
		}
		if(empty($_POST['deadline'])) {
			throw new Exception('Deadline can not be empty');
			
		}
		
		
				if(($user != "") && ($utype_db!="teacher"))
				{
					$d = date("Y-m-d"); //Year - Month - Day
					//throw new Exception('Email is not valid!');
					$sublist = implode(',', $_POST['sub_list']);
					$classlist = implode(',', $_POST['class_list']);
					$mediumlist = implode(',', $_POST['medium_list']);
					$result = mysqli_query($con, "INSERT INTO post (postby_id,subject,class,medium,salary,location,p_university,deadline) VALUES ('$user','$sublist','$classlist','$mediumlist','$_POST[sal_range]','$_POST[location]','$_POST[p_university]','$_POST[deadline]')");
				
				//success message
				$success_message = '
				<div class="signupform_content"><h2><font face="bookman">Post successfull!</font></h2>
				<div class="signupform_text" style="font-size: 18px; text-align: center;"></div></div>';

				//destroy all session
				session_destroy();
				//again start user login session
				session_start();
				$_SESSION['user_login'] = $user;
				header("Location: index.php");
				}else{
					$_SESSION['u_post'] = "post";
					header("Location: login.php");
				}
			}
			catch(Exception $e) {
				$error_message = $e->getMessage();
		}
}

//get sub list
include_once("inc/listclass.php");
$list_check = new checkboxlist();
?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
	
	<!-- date link -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- date link end -->
	
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
			<a class="navlink" href="search.php">Search Tutor</a>
			<?php 
			if($utype_db == "teacher")
				{

				}else {
					echo '<a class="active navlink" href="postform.php">Post</a>';
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
			<div class="postbox">
			<h3>Post Form</h3>
			<?php
				echo '<div class="signup_error_msg">';
					if (isset($error_message)) {echo $error_message;}
				echo'</div>';
				?>
			  	<form action="#" method="post">
			  		<div class="itemrow">
			  			<div style="width: 20%; float: left;">
			  				<label>Subject: </label>
			  			</div>
			  			<div style="width: 80%; float: left;">
			  				<?php $list_check->sublist(); ?>
			  			</div>
			  		</div>
			  	
				
					<div class="itemrow">
						<div style="width: 20%; float: left;">
							<label>Class: </label>
						</div>
						<div style="width: 80%; float: left;">
							<?php $list_check->classlist(); ?>
						</div>
						
					</div>
				  	<div class="itemrow">
				  			<div style="width: 20%; float: left;">
				  				<label>Medium: </label>
				  			</div>
				  			<div style="width: 80%; float: left;">
							<?php $list_check->mediumlist(); ?>
						</div>
					</div>
					<div class="itemrow">
				  			<div style="width: 20%; float: left;">
				  				<label>Salary Range: </label>
				  			</div>
							<div style="width: 80%; float: left;">
								<select name="sal_range">
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
				  			<div style="width: 20%; float: left;">
				  				<label>Location: </label>
				  			</div>
				  			<div style="width: 80%; float: left;">
				  				<?php echo '<input type="text" name="location" value="'.$f_loca.'" placeholder="e.g: Nikunja 2, Banani">'; ?>
				  			</div>
				  		</div>
					<div class="itemrow">
				  			<div style="width: 20%; float: left;">
				  				<label>University: </label>
				  			</div>
							<div style="width: 80%; float: left;">
								<select name="p_university">
								<?php if($f_uni!="") echo '<option value="'.$f_uni.'">'.$f_uni.'</option>';  ?>
							  <option value="None">None</option>
							  <option value="Southeast University">Southeast University</option>
							  <option value="Brac University">Brac University</option>
							  <option value="Dhaka Univesity">Dhaka Univesity</option>
							</select>
							</div>
						</div>
					<div class="itemrow">
				  			<div style="width: 20%; float: left;">
				  				<label>Deadline: </label>
				  			</div>
				  			<div style="width: 20%; float: left;">
				  				<p><?php echo '<input name="deadline" type="text" id="datepicker" placeholder="e.g: 30/10/2017" value="'.$f_dead.'">'; ?></p>
				  			</div>
				  		</div>
					<input type="submit" name="submit" class="sub_button" value="Post"/></br></br>
				</form>
			</div>
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

<!-- main jquery script -->
<script  src="js/jquery-3.2.1.min.js"></script>

<!-- homemenu tab script -->
<script  src="js/homemenu.js"></script>

<!-- topnavfixed script -->
<script  src="js/topnavfixed.js"></script>

<!-- date picker script -->
<script  src="js/datepicker-jquery-ui.js"></script>
<script  src="js/datepicker.js"></script>

	
</body>
</html>