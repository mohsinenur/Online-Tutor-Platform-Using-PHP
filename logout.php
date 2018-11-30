<?php
include ( "inc/connection.inc.php" );

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("Location: index.php");
}
else {
	$user = $_SESSION['user_login'];
	$result = $con->query("UPDATE user SET last_logout=now(), online='no' WHERE id='$user'");
}
//destroy session
session_destroy();
//unset cookies
setcookie('user_login', '', 0, "/");

header("Location: index.php");
?>