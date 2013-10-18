<?php
include '../Login/config.php';
include '../Login/common.php';
include '../Login/users.php';
include '../Login/MenuBar.html';
//var_dump($_SESSION);
// Check if the user is logged in
//var_dump($_SESSION['valid']);
//echo cpm_stats;
$pos = strpos($_SESSION['valid'] ,cpm_stats);
//var_dump($pos);
if( $pos === false){
	header("HTTP/1.1 404 invalid user");
	echo "invalid user";
	exit;
}
session_start();
$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];

if(!isSet($_SESSION['username']))
{
header("Location: /PHP/Login/login.php");
exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Insert SpamCop/Abuse Complaints </title>
</head>

<body>
<script type="text/javascript">
        $(document).ready(function () {
            var theme = getDemoTheme();
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
<form class="form" id="form" method="post" action="saveComplaints.php" style="font-size: 13px; font-family: Verdana; width: 650px;">
<table>
<tr>
<td>
Email Addresses:

</td> 
</tr>
<tr>
<td><textarea rows="6" cols="50"  name="emails"></textarea></td></tr>
<tr><td><select name="compType">
<option value ="spamcop">Spamcop</option>
<option value = "AbuseComplaint">Abuse Complaint</option>
<option value = "litigators">Litigators</option>
<option value ="Balsam Clients">Balsam Clients</option>
<option value ="Legal Threat">Legal Threat</option>
<option value ="Hard Bounce">Hard Bounce</option>
<option value ="Blacklisted">Blacklisted</option>
<option value ="Spamtrap">Spam Trap</option>
</select>
<input type = "submit" value = "Submit"></td></tr>
</table>
</form>
<span>* NOTE: 1 email per row</span>
<div>
</div>
</body>
</html>
