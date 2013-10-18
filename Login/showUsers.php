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
<script type="text/javascript" src="../scripts/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="../scripts/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxscrollview.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.grouping.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.columnsresize.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxgrid.export.js"></script> 
    <script type="text/javascript" src="../jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdata.export.js"></script> 
	<script type="text/javascript" src="../jqwidgets/jqxdatetimeinput.js"></script>
	<script type="text/javascript" src="../jqwidgets/jqxcalendar.js"></script>
	<script type="text/javascript" src="../jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdropdownlist.js"></script>
	<script type="text/javascript" src="../jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxchart.js"></script>
 	<script type="text/javascript" src="../jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jqwidgets/jqxdragdrop.js"></script>
    <script type="text/javascript" src="../scripts/gettheme.js"></script>
    
<script type="text/javascript">
	$(document).ready(function(){
		//create jqxPanel
		 var theme = getDemoTheme();
		 var url = "viewUsers.php";
		 var  source ={
                    datatype: "json",
                    type: "POST",
                    datafields:[
                    { name: 'user_id', type: 'int' },
                    { name: 'username', type: 'string' },
                    { name: 'firstname', type: 'string' },
                    { name: 'lastname', type:'string'},
                    { name: 'email', type: 'string' },
                    { name: 'role_name', type: 'string' },
					{ name: 'descriptions', type:'string'}],
                    url: url
                };
				
			//data adapter
            var dataAdapter = new $.jqx.dataAdapter(source);
			$("#jqxgrid").jqxGrid(
		{
		source: dataAdapter,
		width: 775,
		theme: theme,
		sortable:true,
		autoshowfiltericon: true,
		groupable: true,
		//showfilterrow: true,
		filterable: true,
		sortable: true,
		pageable: true,
		autoheight: true,
		columnsresize: true,
		columns: [
			{ text: 'User ID', datafield: 'user_id', width: 75},
			{ text: 'Username', datafield: 'username', width: 150 },
			{ text: 'First Name', datafield: 'firstname', width: 100 },
			{ text: 'Last Name', datafield: 'lastname', width: 100 },
			{ text: 'Email', datafield: 'email', width: 100 },
			{ text: 'Role', datafield: 'role_name', width: 100 },
			{ text: 'Permissions', datafield: 'descriptions', width: 120 }
		],
		groups:['username']
		});     
		
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
			<article class="breadcrumbs"><a href="admin.php">Website Admin</a><div class="breadcrumb_divider"></div><a class="current" href="showUsers.php">View Users</a></article>
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
              <div id="jqxgrid"></div>
		</div>      
	</section>
</body>
</html>