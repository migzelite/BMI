<?php


$campaign_id = isset($_POST['campaign_id']) ? $_POST['campaign_id'] : null;
$campaign_name = isset($_POST['campaign_name']) ? $_POST['campaign_name'] : null;

$subject_line = isset($_POST['subject_line']) ? $_POST['subject_line'] : null;
$from_line = isset($_POST['from_line']) ? $_POST['from_line'] : null;

$error_array = array();

if (!$campaign_id) $error_array[] = "Error: Campaign ID is a required field.";
if (!$campaign_name) $error_array[] = "Error: Campaign Name is a required field.";



if (count($error_array) > 0 )
{
	echo "Error: Missing required fields";
	exit;
}

//Create the db connection.
$db = new mysqli("localhost", "root", "data!23", "offer_testing");
$result = $db->query("INSERT INTO test_request (campaign_id, campaign_name, from_line, subject_line) VALUES ('$campaign_id', '$campaign_name', '$from_line', '$subject_line')");
echo "Success";