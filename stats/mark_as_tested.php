<?php

//Get the campaign id.
$campaign_id = isset($_POST['campaign_id']) ? $_POST['campaign_id'] : null;
if (!$campaign_id)
{
	echo "No campaign id provided";
	exit;
}

//Get the list count dropped to.
$list_count = isset($_POST['list_count']) ? $_POST['list_count'] : null;
if (!$list_count)
{
	echo "No  list count provided";
	exit;
}

$date_dropped = date("Y-m-d H:i:s");

//Create the db connection.
$db = new mysqli("localhost", "root", "data!23", "offer_testing");

//Update the test request.
$sql = "UPDATE test_request SET scheduled=1 WHERE campaign_id = '$campaign_id'";
$db->query($sql);

//Insert into the campaings tested table.
$sql = "INSERT INTO campaigns_tested (campaign_id, date_dropped, list_count) VALUES ('$campaign_id', '$date_dropped', '$list_count')";
$db->query($sql);

$db->close();

echo "Success";

