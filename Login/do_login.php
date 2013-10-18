<?php
include 'config.php';
include 'users.php';
include 'menu.php';

if(!$do_login) exit;

// declare post fields
$post_url=$_SESSION['redirect_to'] ;
$post_username = trim($_REQUEST['username']);
$post_password = md5(trim($_REQUEST['password']));
//var_dump($post_password);
$post_autologin = $_REQUEST['autologin'];
$role = $_SESSION['role_id'];
//var_dump($role);
if(($post_username == $config_username) && ($post_password == $config_password)&& ($_SESSION['valid']!==false))
{
$login_ok = true;

$_SESSION['username'] = $config_username;

// Autologin Requested?
//$role = PrivilegedUser::getByUsername($config_username);
//var_dump($_SESSION['role_id']);


		if($post_autologin == 1)
		{
			$password_hash = md5($config_password); // will result in a 32 characters hash
		
			setcookie ($cookie_name, 'usr='.$config_username.'&hash='.$password_hash, time() + $cookie_time);
		}
	
		header("Location: admin.php ");
		
		exit;
		


}
//echo alert();

 if ($post_url !=NULL)
	{
		if ($_SESSION['valid'] !==false)
			$permanent = false;
		else $permanent =true;
		function redirect($url,$permanent)
		{
			if($permanent = true)
			{
			
			header('HTTP/1.1 404 invalid user');
			}
			else
			{
			header('Location: '.$url);
			
			exit();
			}
		}
	}

else
{
$login_error = true;
}
?>

	
