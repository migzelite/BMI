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
	header("Location: Home.php");
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
<script type="text/javascript" src="../scripts/gettheme.js"></script>
  <script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxtabs.js"></script>
    <script type="text/javascript" src="../jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdocking.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxsplitter.js"></script>
    
<script type="text/javascript">
	$(document).ready(function(){
		//create jqxPanel
		 var theme = getDemoTheme();
		$('#docking').jqxDocking({ orientation:'horizontal', width:690, mode:'docked'});
		$('#docking').jqxDocking('disableWindowResize', 'window1');
		$('#docking').jqxDocking('disableWindowResize', 'window2');
		//$('#docking').jqxDocking('disableWindowResize', 'window3');
		//$('#docking').jqxDocking('disableWindowResize', 'window4');
		$('#calendar').jqxCalendar({  width: 665, height: 180 });
		
	});
</script>
</head>
<body>
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
			<article class="breadcrumbs"><a href="admin.php">Website Admin</a><div class="breadcrumb_divider"></div><a class="current">Dashborad</a></article>
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
			<li class="icn_view_users" id="showUser"><a href="showUsers.php">View Users</a></li>
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
		<div id='jqxWidget'>
        <div id="docking">
            <div>
                <div id="window1" style="height: 220px;">
                    <div>
                    	Calendar
                    </div>
                    <div style="overflow: hidden;">
                        <div id="calendar" style="float: left; margin-right: 10px;"> </div>
                    </div>
                </div>
                <div id="window2" style="height: 220px">
                    <div>
                        News
                    </div>
                    <div style="padding: 3px; margin: 10px; width: 150px; height: 84px; float: left;">
                    	<script type="text/javascript" src="http://feed.informer.com/widgets/SPIXLHXCLU.js"></script>
                        <noscript><a href="http://feed.informer.com/widgets/SPIXLHXCLU.html">"newsDock"</a>
                        Powered by <a href="http://feed.informer.com/">RSS Feed Informer</a></noscript>
  
  					 </div>
                     </div>
                     </div></div>
                        
                    
	</section>
</body>
</html>