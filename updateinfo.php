<?php
 include ( "inc/connection.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = $con->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$email_db = $get_user_name['email'];
			$uphone_db = $get_user_name['phone'];
			$pro_pic_db = $get_user_name['user_pic'];
			$uaddress_db = $get_user_name['address'];
			$ugender_db = $get_user_name['gender'];
			$utype_db = $get_user_name['type'];

			$result1 = $con->query("SELECT * FROM tutor WHERE t_id='$user' ORDER BY id DESC");
		$get_tutor_name = $result1->fetch_assoc();
			$uinst_db = $get_tutor_name['inst_name'];
			$umedium_db = $get_tutor_name['medium'];
			$usalrange_db = $get_tutor_name['salary'];

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
}


//update pic
if (isset($_POST['updatepic'])) {
	//finding file extention
$profile_pic_name = @$_FILES['profilepic']['name'];
if($profile_pic_name == ""){
	if($result = $con->query("UPDATE user SET phone='$_POST[phone]', address='$_POST[address]' WHERE id='$user'")){
				$succs_message = "Information Updated.";
		}
		if($utype_db == "teacher"){
				if($result = $con->query("UPDATE tutor SET inst_name='$_POST[inst_nm]' WHERE t_id='$user'")){
					$succs_message = "Informaion Updated!";
				}
			}
		header("Location: aboutme.php?uid=".$user."");

}else{
	$file_basename = substr($profile_pic_name, 0, strripos($profile_pic_name, '.'));
$file_ext = substr($profile_pic_name, strripos($profile_pic_name, '.'));
if (((@$_FILES['profilepic']['type']=='image/jpeg') || (@$_FILES['profilepic']['type']=='image/png') || (@$_FILES['profilepic']['type']=='image/jpg') || (@$_FILES['profilepic']['type']=='image/gif')) && (@$_FILES['profilepic']['size'] < 1000000)) {
	if (file_exists("image/profilepic")) {
		//nothing
	}else {
		mkdir("image/profilepic");
	}
	
	
	$filename = strtotime(date('Y-m-d H:i:s')).$file_ext;
	if (file_exists("image/profilepic/".$filename)) {
		$error_message = @$_FILES["profilepic"]["name"]."Already exists";
	}else {
		if(move_uploaded_file(@$_FILES["profilepic"]["tmp_name"], "image/profilepic/".$filename)){
			$photos = $filename;
			if($result = $con->query("UPDATE user SET phone='$_POST[phone]', address='$_POST[address]', user_pic='$photos' WHERE id='$user'")){
				$delete_file = unlink("image/profilepic/".$pro_pic_db);
				$succs_message = "Informaion Updated!";
			}
			if($utype_db == "teacher"){
				if($result = $con->query("UPDATE tutor SET inst_name='$_POST[inst_nm]' WHERE t_id='$user'")){
					$succs_message = "Informaion Updated!";
				}
			}
				header("Location: aboutme.php?uid=".$user."");
		}else {
			$error_message = "File can't move!!!";
		}
		//echo "Uploaded and stored in: userdata/profile_pics/$item/".@$_FILES["profilepic"]["name"];
		
		
	}
	}
	else {
		$error_message = "Choose a picture!";
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
								<form action="" method="POST" class="registration" enctype="multipart/form-data">
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
											<div class="" style="text-align: center; padding-right: 26px;">';
												if (file_exists('image/profilepic/'.$pro_pic_db.'')){
													echo '<img src="image/profilepic/'.$pro_pic_db.'" class="home-prodlist-imgi">';
												}else {
													
													echo'<div class="home-prodlist-imgi" style="text-align: center; padding: 0 0 6px 0;">No Image Found!</div>';
												}
											echo '</div><div style="text-align: center;"><input type="file" name="profilepic" value="Choose"/></div></br>
											<h2 style="text-align: center;">Personal Informaion</h2>

											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Name: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<span>'.$uname_db.'</span>
									  			</div>
								  			</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Email: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<span>'.$email_db.'</span>
									  			</div>
								  			</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Phone: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<input type="text" name="phone" value="'.$uphone_db.'"/>
									  			</div>
								  			</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Gender: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<span>'.ucfirst($ugender_db).'</span>
									  			</div>
								  			</div>
											<div class="itemrow">
									  			<div style="width: 20%; float: left;">
									  				<label>Address: </label>
									  			</div>
									  			<div style="width: 80%; float: left;">
									  				<input type="text" name="address" value="'.$uaddress_db.'"/>
									  			</div>
								  			</div>
											';
												if($utype_db == "student"){

												}else if($utype_db == "teacher"){
													echo '
														<div class="itemrow">
												  			<div style="width: 20%; float: left;">
												  				<label>Institute: </label>
												  			</div>
												  			<div style="width: 80%; float: left;">
												  				<input type="text" name="inst_nm" value="'.$uinst_db.'"/>
												  			</div>
											  			</div>';
												}
											 echo'<input type="submit" class="sub_button" name="updatepic" value="Update"/></br></div><br>
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