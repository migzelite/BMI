<?php
include 'config.php';
// Check if the user is logged in
if(!isSet($_SESSION['username']))
{
header("Location: login.php");
exit;
}
else
{
	header("Location: CPM_Stats/ServiceCallUI.php");
	exit;
}
?>