<?php
include 'config.php';

if(isSet($_SESSION['username']))
{
$_SESSION['username'] = NULL;
unset($_SESSION['username']);
session_unset();
session_destroy();
if(isSet($_COOKIE[$cookie_name]))
{
// remove 'site_auth' cookie
setcookie ($cookie_name, '', time() - $cookie_time);
}

header("Location: login.php");
exit;
}
?>