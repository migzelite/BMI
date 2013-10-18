<?php
include 'config.php';
// Check if the user is logged in
if(!isSet($_SESSION['username']))
{
header("Location: Login/login.php");
exit;
}
else
{
	header("Location: Login/Home.php");
	exit;
}
?>