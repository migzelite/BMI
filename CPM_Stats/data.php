<?php
include "connect.php";

$con = new mysqli($server,$user,$pass,$db_name);

if ($con->connect_errno) {
echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}

$start_date = "";
$end_date = "";
if(isset($_REQUEST['start_date']))
{
$date = DateTime::createFromFormat('n/j/Y H:i:s', $_REQUEST['start_date']);
$start_date = $date->format('Y-m-d H:i:s');
}
if(isset($_REQUEST['end_date']))
{
$date = DateTime::createFromFormat('n/j/Y H:i:s', $_REQUEST['end_date']);
$end_date = $date->format('Y-m-d H:i:s');

}
$sqlRequest = "SELECT * FROM volomp where Start BETWEEN '$start_date' AND '$end_date'";

$result = $con->query($sqlRequest);

// get data and store in a json array
while ($row = $result->fetch_assoc())
{
	$results[] =  array(
				 'MessageID'=>$row['message_id'],
        		 'Start'=>$row['Start'],
				 'Status'=>$row['status'],
				 'Campaign'=>$row['campaign'],
				 'Queued'=>$row['queued'],
				 'CampaignID'=>$row['campaign_id'],
				 'CampaignName'=>$row['campaign_name'],
				 'Processed'=>$row['processed'],
				 'Delivered'=>$row['delivered'],
				 'Bounced'=>$row['bounced'],
				 'OpenPercent'=>$row['open_percent'],
				 'Open'=>$row['open'],
				 'Clicks'=>$row['clicks'],
				 'ClicksPercent'=>$row['clicks_percent']);

}



 header("Content-type: application/json");
 echo json_encode($results);
?>
