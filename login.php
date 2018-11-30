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
	$utype_db = "";
	$user = "";
}
else {
	header("location: index.php");
}
$emails = "";
$passs = "";
if (isset($_POST['login'])) {
	if (isset($_POST['email']) && isset($_POST['password'])) {
		//$user_login = mysql_real_escape_string($_POST['email']);
		$user_login = $_POST['email'];
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");	
		//$password_login = mysql_real_escape_string($_POST['password']);		
		$password_login = $_POST['password'];
		$password_login_md5 = md5($password_login);
		$result = $con->query("SELECT * FROM user WHERE (email='$user_login') AND pass='$password_login_md5'");
		$num = mysqli_num_rows($result);
		$get_user_email = $result->fetch_assoc();
			$get_user_uname_db = $get_user_email['id'];
			$get_user_type_db = $get_user_email['type'];
		if (mysqli_num_rows($result)>0) {
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			$online = 'yes';
			$result = $con->query("UPDATE user SET online='$online' WHERE id='$get_user_uname_db'");
			if($_SESSION['u_post'] == "post")
			{
				//if (isset($_REQUEST['ono'])) {
			//	$ono = mysql_real_escape_string($_REQUEST['ono']);
			//	header("location: orderform.php?poid=".$ono."");
			//}else {
				if($get_user_type_db == "teacher"){
					$_REQUEST['teacher'] = "logastchr";
					header('location: checking.php?teacher=logastchr');
				}else{
					header('location: postform.php');
				}
				
			//}
			}elseif($_REQUEST['pid'] != ""){
				header('location: viewpost.php?pid='.$_REQUEST['pid'].'');
			}else{
				header('location: index.php');
			}
			exit();
		}
		else {
			header('Location: login.php');
			
		}
	}

}
$acemails = "";
$acccode = "";
if(isset($_POST['activate'])){
	if(isset($_POST['actcode'])){
		$user_login = mysql_real_escape_string($_POST['acemail']);
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");	
		$user_acccode = mysql_real_escape_string($_POST['actcode']);
		$result2 = mysql_query("SELECT * FROM user WHERE (email='$user_login') AND confirmCode='$user_acccode'");
		$num3 = mysql_num_rows($result2);
		echo $user_login;
		if ($num3>0) {
			$get_user_email = mysql_fetch_assoc($result2);
			$get_user_uname_db = $get_user_email['id'];
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			mysql_query("UPDATE user SET confirmCode='0', activation='yes' WHERE email='$user_login'");
			if (isset($_REQUEST['ono'])) {
				$ono = mysql_real_escape_string($_REQUEST['ono']);
				header("location: orderform.php?poid=".$ono."");
			}else {
				header('location: index.php');
			}
			exit();
		}else {
			$emails = $user_login;
			$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Code not matched!<br>
				</font></div>';
		}
	}else {
		$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Activation code not matched!<br>
				</font></div>';
	}

}

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/reg.css" rel="stylesheet" type="text/css" media="all" />
	<!-- menu tab link -->
	<link rel="stylesheet" type="text/css" href="css/homemenu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

</head>
<body class="">
<div>
<div>
		<header class="header">

			<div class="header-cont">

				<?php
					include 'inc/banner.inc.php';
				?>

			</div>
		</header>
		<div class="w3-sidebar w3-bar-block w3-collapse w3-card-2 w3-animate-left" style="width:100px;" id="mySidebar">
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
								echo '<td>
							<a class="active navlink" href="profile.php?uid='.$user.'">'.$uname_db.'</a>
						</td>
						<td>
							<a class="navlink" href="logout.php">Logout</a>
						</td>';
							}else{
								echo '<td>
							<a class="active navlink" href="login.php">Login</a>
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
	<div class="nbody" style="margin: 0px 100px; overflow: hidden;">
		<div class="nfeedleft" style="background-color: unset;">
			<div>
		<div class="testbox" style="height: 280px;">
  <h1>Login</h1>

  <form action="" method="post">
      <hr>
  <input type="text" name="email" id="name" placeholder="Email" required/>
  <input type="password" name="password" id="name" placeholder="Password" required/>
  <div>
  <div style="float: right; width: 35%; margin-top: 10px;">
  	<input type="submit" class="sub_button" name="login" id="name" value="Login"/><br><br>
  </div>
  <div style="width: 50%; float: left; padding: 10px 0 5px 4px">
  	<p>Forget your password?<a href="#" style="font-weight: bold;">Click here</a>.</p>
  <p>Not registered yet?<a href="registration.php" style="font-weight: bold;">Register here</a>.</p>
  </div>
  </div>
  </form>
</div>
	</div>
		</div>
		<div class="nfeedright">
			
		</div>
	</div>

	
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