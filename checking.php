<?php
 include ( "inc/connection.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header('location: logout.php');
}
else {
	$user = $_SESSION['user_login'];
	$result = $con->query("SELECT * FROM user WHERE id='$user'");
		$get_user_name = $result->fetch_assoc();
			$uname_db = $get_user_name['fullname'];
			$utype_db = $get_user_name['type'];
}

if (isset($_REQUEST['teacher'])) {
	if($_REQUEST['teacher'] == "logastchr"){
		$error = "You Logged as Teacher. Only Student can post!";
	}else{
		header('location: logout.php');
	}
}else{
		header('location: logout.php');
	}

?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="css/footer.css" rel="stylesheet" type="text/css" media="all" />
	
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
			<a  onclick="w3_open()"><img src="image/menuicon2.png" width="16px" height="15px"></a>
			<a class="active" href="index.php" style="margin: 0px 0px 0px 52px;">Newsfeed</a>
			<a href="search.php">Search Tutor</a>
			<?php 
			if($utype_db == "teacher")
				{

				}else {
					echo '<a href="postform.php">Post</a>';
				}

			 ?>
			<a href="#contact">Contact</a>
			<a href="#about">About</a>
			<div style="float: right;" >
				<table>
					<tr>
						<?php
							if($user != ""){
								echo '<td>
							<a href="profile.php?uid='.$user.'">'.$uname_db.'</a>
						</td>
						<td>
							<a href="logout.php">Logout</a>
						</td>';
							}else{
								echo '<td>
							<a href="login.php">Login</a>
						</td>
						<td>
							<a href="registration.php">Register</a>
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
					echo '
						<div class="nfbody">
					<div class="p_body">
						<p>'.$error.'</p>
					</div>
				</div>';

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
<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
</script>
</body>
</html>