<?php
 include ( "inc/connection.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("Location: index.php");
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

if (isset($_REQUEST['uid'])) {
	$pstid = mysqli_real_escape_string($con, $_REQUEST['uid']);
	$result1 = $con->query("SELECT * FROM tutor WHERE t_id='$user' ORDER BY id DESC");
	$get_tutor_name = $result1->fetch_assoc();
	$tid_db = $get_tutor_name['t_id'];
	$id_db = $get_tutor_name['id'];
	$uinst_db = $get_tutor_name['inst_name'];
	$medium = $get_tutor_name['medium'];
	$cls = $get_tutor_name['class'];
	$sub = $get_tutor_name['prefer_sub'];
	$f_sal = $get_tutor_name['salary'];
	$plocation_db = $get_tutor_name['prefer_location'];

	if($user != $_REQUEST['uid']){
		header('location: index.php');
	}else{

	}
}else {
	header('location: index.php');
}


//posting
if (isset($_POST['updatetutioninfo'])) {

	$f_loca = $_POST['location'];
	$f_sal = $_POST['sal_range'];


	try {
				if(($user == $_REQUEST['uid']) && ($utype_db == "teacher"))
				{
					
					//throw new Exception('Email is not valid!');
					$sublist = implode(',', $_POST['sub_list']);
					$classlist = implode(',', $_POST['class_list']);
					$mediumlist = implode(',', $_POST['medium_list']);

					//not working!!!!!!!!!!!!
					//$result3 = mysqli_query($con, "UPDATE tutor SET prefer_sub='$sublist',class='$classlist',medium='$mediumlist',salary='$f_sal',prefer_location='$f_loca', WHERE t_id='$user'");

					if($result4 = $con->query("INSERT INTO tutor (t_id,prefer_sub,class,medium,inst_name,salary,prefer_location) VALUES ('$user','$sublist','$classlist','$mediumlist','$uinst_db','$_POST[sal_range]','$_POST[location]')")){
						$result = $con->query("DELETE FROM tutor WHERE id='$id_db'");
						
					}
				
				//success message
				$success_message = '
				<div class="signupform_content"><h2><font face="bookman">Post successfull!</font></h2>
				<div class="signupform_text" style="font-size: 18px; text-align: center;"></div></div>';

				header("Location: aboutme.php?uid=".$user."");
				}
			}
			catch(Exception $e) {
				$error_message = $e->getMessage();
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
				<li style="float: left;">
					<div class="settingsleftcontent">
						<ul>
							<li><?php echo '<a href="profile.php?uid='.$user.'" >Post</a>'; ?></li>
							<li><?php echo '<a href="aboutme.php?uid='.$user.'">About</a>'; ?></li>
							<li><?php echo '<a href="settings.php">Settings</a>'; ?></li>
						</ul>
					</div>
				</li>
				<li style="float: right;">
								<form action="" method="POST" class="registration">
								<?php 
									echo '
										<div class="holecontainer">
										<div class="nfbody">
										<div class="p_body">';
													if (isset($error_message)) {
														echo '<div class="signup_error_msg" style="
  color: #A92A2A;">'.$error_message.'</div>';
													}elseif(isset($succs_message)){
														echo '<div class="signup_error_msg" style="
  color: #A92A2A;">'.$succs_message.'</div>';
													}
												echo'
											<h2 style="text-align: center;">Update Tution Informaion</h2>'; ?>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Medium: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<div class="divp50"><input <?php $medium1=strstr($medium, "Bangla"); if($medium1 != '') echo 'checked'; ?> type="checkbox" name="medium_list[]" value="Bangla"><span>Bangla</span></div>
													<div class="divp50"><input <?php $medium1=strstr($medium, "English"); if($medium1 != '') echo 'checked'; ?> type="checkbox" name="medium_list[]" value="English"><span>English</span></div>
													<div class="divp50"><input <?php $medium1=strstr($medium, "Any"); if($medium1 != '') echo 'checked'; ?> type="checkbox" name="medium_list[]" value="Any"><span>Any</span></div>
									  		</div>
									  		</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Prefer Subject: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<div class="divp50"><input <?php $sub1=strstr($sub, "Bangla"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Bangla"><span>Bangla</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "English"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="English"><span>English</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Math"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Math"><span>Math</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Social Science"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Social Science"><span>Social Science</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "General Science"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="General Science"><span>General Science</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Religion"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Religion"><span>Religion</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "ICT"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="ICT"><span>ICT</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Physics"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Physics"><span>Physics</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Chemistry"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Chemistry"><span>Chemistry</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Higher Math"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Higher Math"><span>Higher Math</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Biology"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Biology"><span>Biology</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Sociology"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Sociology"><span>Sociology</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Economics"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Economics"><span>Economics</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Accounting"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Accounting"><span>Accounting</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "History"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="History"><span>History</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Finance"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Finance"><span>Finance</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Statistics"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Statistics"><span>Statistics</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Civics"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Civics"><span>Civics</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Computer Science"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Computer Science"><span>Computer Science</span></div>
													<div class="divp50"><input <?php $sub1=strstr($sub, "Art"); if($sub1 != '') echo 'checked'; ?> type="checkbox" name="sub_list[]" value="Art"><span>Art</span></div>
									  			</div>
									  		</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Prefer Class: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<div class="divp50"><input <?php $class1=strstr($cls, "One-Three"); if($class1 != '') echo 'checked'; ?> type="checkbox" name="class_list[]" value="One-Three"><span>One-Three</span></div>
													<div class="divp50"><input <?php $class1=strstr($cls, "Four-Five"); if($class1 != '') echo 'checked'; ?> type="checkbox" name="class_list[]" value="Four-Five"><span>Four-Five</span></div>
													<div class="divp50"><input <?php $class1=strstr($cls, "Six-Seven"); if($class1 != '') echo 'checked'; ?> type="checkbox" name="class_list[]" value="Six-Seven"><span>Six-Seven</span></div>
													<div class="divp50"><input <?php $class1=strstr($cls, "Eight"); if($class1 != '') echo 'checked'; ?> type="checkbox" name="class_list[]" value="Eight"><span>Eight</span></div>
													<div class="divp50"><input <?php $class1=strstr($cls, "Nine-Ten"); if($class1 != '') echo 'checked'; ?> type="checkbox" name="class_list[]" value="Nine-Ten"><span>Nine-Ten</span></div>
													<div class="divp50"><input <?php $class1=strstr($cls, "Eleven-Twelve"); if($class1 != '') echo 'checked'; ?> type="checkbox" name="class_list[]" value="Eleven-Twelve"><span>Eleven-Twelve</span></div>
													<div class="divp50"><input <?php $class1=strstr($cls, "College/University"); if($class1 != '') echo 'checked'; ?> type="checkbox" name="class_list[]" value="College/University"><span>College/University</span></div>
									  		<?php	echo '</div>
									  		</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Prefer Location: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<input type="text" name="location" value="'.$plocation_db.'"/>
									  			</div>
									  		</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Salary: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<select name="sal_range">';
														if($f_sal!="") echo '<option value="'.$f_sal.'">'.$f_sal.'</option>';
													  echo '<option value="None">None</option>
													  <option value="1000-2000">1000-2000</option>
													  <option value="2000-5000">2000-5000</option>
													  <option value="5000-10000">5000-10000</option>
													  <option value="10000-15000">10000-15000</option>
													  <option value="15000-25000">15000-25000</option>
													</select>
									  			</div>
									  		</div>
									  		<input type="submit" class="sub_button" name="updatetutioninfo" value="Update"/><br></div><br>
										</div></div>'
								 ?>
							</form>
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