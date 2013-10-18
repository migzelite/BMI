<?php

include "connect.php";
$con = new mysqli($server,$user,$pass,$db_name);
if ($con->connect_errno) {
echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}
$user="";
$passw="";
$firstname="";
$lastname="";
$email="";
if(isset($_REQUEST['username']))
{
	$user = $_REQUEST['username'];
	//var_dump($user);
}
if(isset($_REQUEST['password']))
{
	$passw = md5($_REQUEST['password']);
	//var_dump($passw);
}
if(isset($_REQUEST['firstname']))
{
	$firstname = $_REQUEST['firstname'];
	//var_dump($firstname);
}
if(isset($_REQUEST['lastname']))
{
	$lastname = $_REQUEST['lastname'];
	//var_dump($lastname);
}
if(isset($_REQUEST['email']))
{
	$email = $_REQUEST['email'];
	//var_dump($email);
}
if(isset($_REQUEST['user_type']))
{
	$role = $_REQUEST['user_type'];
	//var_dump($role );
}
if(isset($_REQUEST['permissions']))
{
	$permissions[]= $_REQUEST['permissions'];
	//var_dump($permissions);
}
$query = "INSERT INTO `users` (username,password,FirstName,LastName,email, userlevel) VALUES ('".$user."','".$passw."','".$firstname."','".$lastname."','".$email."','".$role."')";
//var_dump($query);
$results = $con->query($query);
if (!$results )//|| !$result2
 	{	
 		
	   	$message  = 'Invalid query: ' . mysqli_error($con) . "\n";
	    $message .= 'Whole query: ' . $query;
	    die("Error <br />User name already being used");
	}
$sqluser = "SELECT user_id FROM `users` WHERE username = '".$user."'";
$uID = $con->query($sqluser) or die("SQL Error 1: " . mysqli_error($con));
	while ($row = mysqli_fetch_array($uID,MYSQLI_ASSOC))
	{
		$id = $row['user_id'];
	}
$sqlUserRole = "INSERT INTO `user_role` (user_id,role_id) VALUES ('".$id."','".$role."')";
$res1 = $con->real_query($sqlUserRole);
if (!$res1)//|| !$result2
 	{	
 		
	   	$message  = 'Invalid query: ' . mysqli_error($con) . "\n";
	    $message .= 'Whole query: ' . $query;
	    die("Error <br />User name already being used");
	}
	
	foreach($permissions as $key => $values){
		foreach($values as $value){
			//var_dump($value);
	$sqlRolePerm = "INSERT INTO `role_perm` (role_id,user_id,perm_id) Values ('".$role."','".$id."','".	$value."')";
	$res2 =$con->real_query($sqlRolePerm);
if (!$res1)//|| !$result2
 	{	
 		
	   	$message  = 'Invalid query: ' . mysqli_error($con) . "\n";
	    $message .= 'Whole query: ' . $query;
	    die("Error <br />User name already being used");
	}
		}
	}
	
	$con->close();
echo "Users has been added";	
header("Location: login.php");
exit;	
?>



