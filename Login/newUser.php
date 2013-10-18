<?php
include '../Login/config.php';
include '../Login/common.php';
include '../Login/users.php';
//var_dump($_SESSION);
// Check if the user is logged in
//var_dump($_SESSION['valid']);
//echo cpm_stats;
//$pos = strpos($_SESSION['valid'] ,cpm_stats);
//var_dump($pos);
/*if( $pos === false){
	header("HTTP/1.1 404 invalid user");
	echo "invalid user";
	exit;
}*/

session_start();
if($_SESSION['role_id'] !== 1)
{
	header("Location: home.php");
	echo "invalid user";
	exit;
}
$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];

if(!isSet($_SESSION['username']))
{
header("Location: login.php");
exit;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset ="utf-8"/>
<title>Stats Dashboard AdminPanel</title>
<link rel="stylesheet" href="../jqwidgets/styles/layout.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../jqwidgets/styles/blakes_theme.css" type="text/css" />
<link rel="stylesheet" href="../jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxvalidator.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxmaskedinput.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxexpander.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="../scripts/gettheme.js"></script>
       <style type="text/css">
       .demo-iframe {
            border: none;
            width: 600px;
            height: 400px;
            clear: both;
            display: none;
        }

        .text-input {
	height: 23px;
	width: 150px;
	background-color: #FFFFFF;
        }

        .register-table {
            margin-top: 10px;
            margin-bottom: 10px;
        }

            .register-table td,
            .register-table tr {
                border-spacing: 0px;
                border-collapse: collapse;
                font-family: Verdana;
                font-size: 12px;
            }

        h3 {
            display: inline-block;
            margin: 0px;
        }

        .prompt {
            margin-top: 10px;
            font-size: 10px;
        }
       </style>
</head>
<body bgcolor="#FFFFFF" text="#000033">
<script type="text/javascript">
        $(document).ready(function () {
            var theme = getDemoTheme();
       
                 
           // $("#createAccount").jqxExpander({ theme: theme, toggleMode: 'none', width: '350px', showArrow: false });
            $('#sendButton').jqxButton({ width: 145, height: 25 });
            $('.text-input').addClass('jqx-input');
            $('.text-input').addClass('jqx-rc-all');
            if (theme.length > 0) {
                $('.text-input').addClass('jqx-input-' );
                $('.text-input').addClass('jqx-widget-content-' );
                $('.text-input').addClass('jqx-rc-all-');
            }
            var date = new Date();
            date.setFullYear(1985, 0, 1);
            
            // initialize validator.
            $('#form').jqxValidator({
                rules: [
                { input: '#userInput', message: 'Username is required!', action: 'keyup, blur', rule: 'required' },
                { input: '#userInput', message: 'Your username must be between 3 and 12 characters!', action: 'keyup, blur', rule: 'length=3,12' },
                { input: '#firstNameInput', message: 'Real Name is required!', action: 'keyup, blur', rule: 'required' },
                { input: '#firstNameInput', message: 'Your real name must contain only letters!', action: 'keyup', rule: 'notNumber' },
                { input: '#firstNameInput', message: 'Your real name must be between 3 and 12 characters!', action: 'keyup', rule: 'length=3,12' },
                { input: '#lastNameInput', message: 'Real Name is required!', action: 'keyup, blur', rule: 'required' },
                { input: '#lastNameInput', message: 'Your real name must contain only letters!', action: 'keyup', rule: 'notNumber' },
                { input: '#lastNameInput', message: 'Your real name must be between 3 and 12 characters!', action: 'keyup', rule: 'length=3,12' },
                { input: '#emailInput', message: 'email is required!', action: 'keyup, blur', rule: 'required' },
                { input: '#passwordInput', message: 'Password is required!', action: 'keyup, blur', rule: 'required' },
                { input: '#passwordInput', message: 'Your password must be between 4 and 12 characters!', action: 'keyup, blur', rule: 'length=4,12' },
                { input: '#passwordConfirmInput', message: 'Password is required!', action: 'keyup, blur', rule: 'required' },
                {
                    input: '#passwordConfirmInput', message: 'Passwords doesn\'t match!', action: 'keyup, focus', rule: function (input, commit) {
                        // call commit with false, when you are doing server validation and you want to display a validation error on this field.
                        if (input.val() === $('#passwordInput').val()) {
                            return true;
                        }
                        return false;
                    }
                }]
                });
                
            // validate form.
           
            $("#form").on('validationSuccess', function () {
               // $("#createAccount").jqxExpander('setContent', '<span style="margin: 10px;">Account created.</span>');
                $("#form-iframe").fadeIn('fast');
                

            });
            $("#sendButton").click(function () {
                var validationResult = function (isValid) {
                    if (isValid) {
                        $("#form").submit();
                    }
                }
                $('#form').jqxValidator('validate', validationResult);
            });
        });
    </script>
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="admin.php">Website Admin</a></h1>	
			<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="Home.php">View Site</a></div>
		</hgroup>
	</header>
	<section id="secondary_bar">
		<div class="user">
			<p>Admin (<a href="#">Messages</a>)</p>	
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a href="admin.php">Website Admin</a><div class="breadcrumb_divider"></div><a class="current" href="newUser.php">Add User</a></article>
		</div>
	</section>
	<aside id="sidebar" class="column">
     
		<form class="quick_search">
			<input type="text" value="quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
		</form>
		<hr/>
		<h3>Users</h3>
		<ul class="toggle">
			<li class="icn_add_user" ><a href="newUser.php">Add New User</a></li>
			<li class="icn_view_users" id="viewUser"><a href="showUsers.php">View Users</a></li>
			<li class="icn_profile" id="profile"><a href="#">Your Profile</a></li>
		</ul>
		<h3>Admin</h3>
		<ul class="toggle">
			<li class="icn_settings"><a href="#">Options</a></li>
			<li class="icn_security"><a href="#">Security</a></li>
			<li class="icn_jump_back"><a href="logout.php">Logout</a></li>
		</ul>
	</aside>
  	<section id="main" class="column">
        <div style='margin: 10px;'>
 
<form class="form" id="form" target="form-iframe" method="post" action="addUser.php" >							
  <div>
                <h2>Add User</h2>
            </div>
   <div align="justify">
      <table width="317" height="369" class="jqx-panel">
          <tr>
              <td width="313">Username:</td>
              <td width="150"><input name="username" type="text" id="userInput" class="text-input" /></td>
          </tr>
          <tr>
              <td>Password:</td>
              <td><input name="password" type="password" id="passwordInput" class="text-input" /></td>
          </tr>
          <tr>
              <td>Confirm password:</td>
              <td><input type="password" id="passwordConfirmInput" class="text-input" /></td>
          </tr>
          <tr>
              <td>First name:</td>
              <td><input name="firstname" type="text" id="firstNameInput" class="text-input" /></td>
          </tr>
          <tr>
              <td>Last name:</td>
              <td><input name="lastname" type="text" id="lastNameInput" class="text-input" /></td>
          </tr>
          <tr>
              <td>Email:</td>
              <td><input name="email" type="text" id="emailInput" class="text-input" /></td>
          </tr>
          <tr>
              <td>user type</td>
              <td><input name="user_type" type="checkbox" id="admin" class="checkbox" value=1/>Admin</td>
              <td width="364" style=""><input name="user_type" type="checkbox" id="user" class="checkbox" value=2 />User</td>
          </tr>
          <tr>
              <td>Permissions</td>
              <td><ul>
                <li><input name="permissions[]" type="checkbox" id="Home" class="checkbox" value=1 checked/>Home</li>
                <li><input name="permissions[]" type="checkbox" id="cpm" class="checkbox" value=2 />CPM</li>
                <li><input name="permissions[]" type="checkbox" id="offer_testing" class="checkbox" value=3 />Offer</li>
                <li><input name="permissions[]" type="checkbox" id="graphic_stats" class="checkbox" value=4 />Graphic</li>
                <li><input name="permissions[]" type="checkbox" id="text_stats" class="checkbox" value=5 />Text</li>
                <li><input name="permissions[]" type="checkbox" id="complaints" class="checkbox" value=6 />Complaints</li>
                <li><input name="permissions[]" type="checkbox" id="logout" class="checkbox" value=7 checked/>Logout</li>
              </ul></td>
          </tr>
             
          <tr>
              <td colspan="2" style="text-align: center;"><span style="text-align: right;">
              <input type="reset" class="jqx-tooltip-text-blakes_theme"  value="Clear">
              <input type="button" class="jqx-tooltip-text-blakes_theme" id="sendButton" value="Add User" />
              </span></td>
              <td colspan="3" style="text-align: right;"></tr>
      </table>
  </div>
</form>
            
         </section>
</body>
</html>