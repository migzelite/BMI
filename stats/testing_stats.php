<?php
require_once 'plugins/linktrust_partner.inc.php';
require_once 'libs/curl.inc.php';

//Create the db connection.
$db = new mysqli("localhost", "root", "data!23", "offer_testing");

$key = "5f202f8c-3d32-48d3-b84b-654f62fd02b5";
$id = "2625";
$linktrust = new clsLinkTrustPartnerAPI($key, $id);

$sql = "SELECT campaign_id, date_dropped, list_count FROM campaigns_tested";
$result = $db->query($sql);


//See if we found the last id.
if ($result->num_rows > 0)
{
	//Loop through the result set.
	while (($row = $result->fetch_assoc()) != false)
	{

		$campaign_id = $row['campaign_id'];
		$start_date = '2013-06-01 00:00:00';
		$end_date = date('Y-m-d') . ' 23:59:59';

		$stats = $linktrust->GetStatsForCampaignForAffiliate($campaign_id, '276928', $start_date, $end_date);
		$row['campaign_name'] = $stats->campaign_name;
		$row['clicks'] = $stats->clicks;
		$row['conversions'] = $stats->conversions;
		$row['conversion_percent'] = $stats->conversion_percent;
		$row['epc'] = $stats->epc;

		$result_data[] = $row;
	}

}

//close the db connection.
$db->close();

header("Content-type: application/json");
echo "{\"data\":" .json_encode($result_data). "}";
