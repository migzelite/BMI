<?php

function displayResults(){
	include_once 'connect.php';
	$con = new mysqli($server,$user,$pass,$db_name);

if ($con->connect_errno) {
echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}
			 $sql =  "SELECT DISTINCT * FROM volomp";
			 $res = $con->query($sql) or die("SQL Error 1: " . mysqli_error($con));
			// $resultFinished = mysqli_query($con,"SELECT * FROM finshed");
		
			 while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC))
			 {
				 $results[] = array(
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
			echo json_encode($results,JSON_PRETTY_PRINT);
			$error = json_last_error();
		
			
		 }	
	
	displayResults();
?>


