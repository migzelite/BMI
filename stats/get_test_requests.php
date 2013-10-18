<?php


//Create the db connection.
$db = new mysqli("localhost", "root", "data!23", "offer_testing");

//Create the sql.
$sql = "SELECT campaign_id, campaign_name, from_line, subject_line, date_request_submitted FROM test_request WHERE scheduled = 0";

$res = $db->query($sql);

//Loop through the results set.
while ($row = $res->fetch_assoc())
{
	$result_data[] = $row;
}

header("Content-type: application/json");
echo "{\"data\":" .json_encode($result_data). "}";