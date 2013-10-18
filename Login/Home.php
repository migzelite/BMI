<?php
include 'config.php';
include 'users.php';
include 'MenuBar.html';
include 'showfeed.php';
if(!isSet($_SESSION['username']))
{
header("Location: login.php");
exit;
}
?>
<html>
<head>
<link rel="stylesheet" href="../jqwidgets/styles/rss.css" type="text/css" />

<body>


<div id="rssOutput"></div>

</body>
</html>


