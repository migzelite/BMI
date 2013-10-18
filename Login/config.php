<?php
include 'connect.php';

error_reporting(E_ALL ^ E_NOTICE);

session_start();
header('Cache-control: private'); // IE 6 FIX

// always modified
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
// HTTP/1.1
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
// HTTP/1.0
header('Pragma: no-cache');

// ---------- Login Info ---------- //
$con = new mysqli($server ,$user,$pass,$db_name);
$uname="";
$pass= "";
//var_dump($pass);if ($con->connect_errno) {
if ($con->connect_errno) {
	echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}



$uname= $con->real_escape_string($_REQUEST['username']);
//var_dump($uname);

$pass=md5($con->real_escape_string($_REQUEST['password']));
//var_dump($pass);
$sqluser = "SELECT u.username,u.password,ur.role_id FROM users u
		inner join user_role ur on ur.user_id = u.user_id 
		WHERE u.username ='" .$uname. "' AND password = '".$pass. "'"  ;
//echo $sqluser;
$resUser=$con->query($sqluser)or die("SQL Error 1: " . mysqli_error($con));
while ($row = $resUser->fetch_array())
{
	$resultsUser[] = array(
		 $row['username'],
		 $row['password'],
		 $row['role_id']			
	);
 //var_dump($resultsUser);
}
 //var_dump($resultsUser);
//list($config_username,$config_password) = $resultsUser;

/* foreach($resulstUser as $key1=>$val1)
	
 {
 	if ($key1 == 'perm_id'){
 		$perm_id[]=push($val1);
 	}
 }*/
$config_username= $resultsUser[0][0];
$config_password= $resultsUser[0][1];
$role_id = $resultsUser[0][2];
$resUser->free();





		//$role_id =  $resultsUser[0][2];
		//var_dump($config_username);
		//var_dump($config_password);
		//var_dump($role_id);
//$config_username = 'user';
//$config_password = 'demo123';


		 
// ---------- Cookie Info ---------- //

$cookie_name = 'siteAuth';
$cookie_time = (3600 * 24 * 30); // 30 days

// ---------- Invoke Auto-Login if no session is registered ---------- //

if(!$_SESSION['username'])
{
include_once 'autologin.php';
}

?>
