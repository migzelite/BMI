<?php
require_once 'config.php';

//var_dump($_SESSION);

// Is the user already logged in? Redirect him/her to the home page

if($_SESSION['username'])
{
header("Location: Home.php");
exit;
}

if(isSet($_REQUEST['submit']))
{
$do_login = true;

include_once 'do_login.php';
}
?>

 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE>Login Form</TITLE>
  <META name="Author" Content="Bit Repository">
  <META name="Keywords" Content="form, divs">
  <META name="Description" Content="A CSS Tableless Form Design">
  <link rel="stylesheet" href="../jqwidgets/styles/jqx.base.css" type="text/css" />
<STYLE TYPE="text/css">
<!--
HTML, BODY 
{
padding: 0;border: 0px none; 
}


.background{
	background-position: -436px -196px ;
	width: 0px;
	height: 0px;
	
}


/* Stylish FieldSet */
fieldset 
{ 
-moz-border-radius: 7px; border: 1px #dddddd solid; padding: 10px; width: 330px; margin-top: 10px; 
}

fieldset legend 
{ 
border: 1px #1a6f93 solid; color: black; font: 13px Verdana; padding: 2 5 2 5; -moz-border-radius: 3px; 
}

/* Label */
label  
{ 
width: 100px; padding-left: 20px; margin: 5px; float: left; text-align: left; 
}

/* Input text */
input { margin: 5px; padding: 0px; float: left; }

/* 'Login' Button */
#submit { margin: 5px; padding: 0px; float: left; width: 50px; background-color: white; }
/* create account Button */
#create { margin: 5px; padding: 0px; float: left; width: 100px; background-color: white; }
#error_notification
{
border: 1px #A25965 solid;
height: auto;
padding: 4px;
background: #F8F0F1;
text-align: center;
-moz-border-radius: 5px;
}

-->
/* BR */

br { clear: left; }

</STYLE>

</HEAD>

 <BODY>
 
<center>

<div align="left" style="width: 330px;">
<form name="login" method="post" action="login.php">

<fieldset><legend>Authentication</legend>

<?php
if(isSet($login_error))
{
echo '<div id="error_notification">The submitted login info is incorrect.</div>';
}
?> 

<label>Username</label><input id="name" type="text" name="username"><br />

<label>Password</label><input type="password" name="password"><br />

<label>&nbsp;</label><input type="checkbox" name="autologin" value="1">Remember Me<br />

<label>&nbsp;</label><input id="submit" type="submit" name="submit" value="Login">

<input id="create" type="button" name="create" value="Create Account" onclick="location.href='../Login/createaccount.html';"><br />

</fieldset>

</form>
</div>

</center>

 </BODY>
</HTML> 

