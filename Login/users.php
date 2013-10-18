<?php 
//include 'connect.php';
include_once 'config.php';
// get/set session permissions		
// check if url is in permission list
//$con = new mysqli($server,$user,$pass,$db_name);

if ($con->connect_errno) {
	echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}
//var_dump($_SESSION['username']);
$sqlperm = "SELECT p.page_id FROM page p
INNER JOIN page_perm pp on pp.page_id =p.page_id
INNER JOIN role_perm rp on rp.perm_id = pp.perm_id
INNER JOIN roles r on r.role_id = rp.role_id
INNER JOIN users u on u.user_id = rp.user_id
WHERE u.username ='".trim($_SESSION['username'])."'";

//echo $sqluser;
$resurl=$con->query($sqlperm)or die("SQL Error 2: " . mysqli_error($con));
$urls =array();
while ($row = $resurl->fetch_array())
{
	$id[] = $row['page_id'];


}

//var_dump($id);
$perm =implode(",",$id);
//var_dump($perm);
session_start();
$_SESSION['valid']=$perm;
//var_dump($_SESSION['valid']);
//$permissions= implode(",",$id);


$sqlrole = "SELECT DISTINCT ur.role_id from user_role ur
			INNER JOIN users u on u.user_id = ur.user_id
			WHERE u.username = '".trim($_SESSION['username'])."'";
$resrole=$con->query($sqlrole)or die("SQL Error 3: " . mysqli_error($con));
$role[] = array();
while ($row = $resrole->fetch_array())
{
	$role[] = $row['role_id'];


}
//var_dump($role);
$rolesid=(int)$role[1];
//var_dump($rolesid);
 $_SESSION['role_id']=$rolesid;
//$_SESSION['role_id'] = str_replace('Array,','',$_SESSIOM['role_id']);
//var_dump($_SESSION['role_id']);
//var_dump($_SESSION['redirect_to']);


session_start();
 $_SESSION['role_id']=$rolesid;
//var_dump($_SESSION['role_id']);
?>