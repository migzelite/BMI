<?php

require_once 'plugins/cake.inc.php';
require_once 'plugins/adstation.inc.php';
require_once 'plugins/linktrust.inc.php';
require_once 'plugins/linktrust_partner.inc.php';

$mailer = $_REQUEST['mailer'];


if (empty($_REQUEST['start_date'])) $start_date =  date("Y-m-d") . " 00:00:00";
else {

	$date = DateTime::createFromFormat('n/j/Y H:i:s', $_REQUEST['start_date'] . " 00:00:00");
	$start_date = $date ->format('Y-m-d H:i:s');

	//$start_date = date('Y-m-d', $_REQUEST['start_date']) . '00:00:00';
	//echo $start_date;

}

if (empty($_REQUEST['end_date'])) $end_date =  date("Y-m-d") . " 23:59:59";
else {
	$date = DateTime::createFromFormat('n/j/Y H:i:s', $_REQUEST['end_date'] . " 23:59:59");
	$end_date = $date ->format('Y-m-d H:i:s');
	//$end_date = date('Y-m-d', $_REQUEST['end_date']) . " 23:59:59";
}


$result_data = array();


if ($mailer == "BMI")
{
$total = 0.00;


	//Clickbooth for bmi
	$domain_name = "affiliates.clickbooth.com";
	$api_key = '2zb9bvOgUCsmomDO4lTIYQ';
	$aff_id = '836303';
	$cake = new clsCakeApiPlugin($domain_name, $api_key, $aff_id);
	$rev = (double)$cake->GetRevenueForTimePeriod($start_date, $end_date);
	$result_data[] = array("system" => "Clickbooth", "revenue" => $rev );

	$total = $rev;

	//Clickbooth for bmi
	$domain_name = "affiliates.clickbooth.com";
	$api_key = '2zb9bvOgUCtMNS89tiWtQQ';
	$aff_id = '836305';
	$cake = new clsCakeApiPlugin($domain_name, $api_key, $aff_id);
	$rev = (double)$cake->GetRevenueForTimePeriod($start_date, $end_date);
	$result_data[] = array("system" => "Clickbooth", "revenue" => $rev );

	$total = $total + $rev;

	//Adstation volo 1
	$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
	$guid = 4796;
	$adstation = new clsAdstationApiPlugin($token);
	$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
	$result_data[] = array("system" => "Adstation1", "revenue" => $rev );

	$total = $total + $rev;

	//Adstation volo 2
	$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
	$guid = 4931;
	$adstation = new clsAdstationApiPlugin($token);
	$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
	$result_data[] = array("system" => "Adstation2", "revenue" => $rev );

	$total = $total + $rev;

	//Adstation volo 3
	$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
	$guid = 4932;
	$adstation = new clsAdstationApiPlugin($token);
	$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
	$result_data[] = array("system" => "Adstation3", "revenue" => $rev );

	$total = $total + $rev;

	//Adstation volo 4
	$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
	$guid = 4939;
	$adstation = new clsAdstationApiPlugin($token);
	$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
	$result_data[] = array("system" => "Adstation4", "revenue" => $rev );

	$total = $total + $rev;


	$key = "5f202f8c-3d32-48d3-b84b-654f62fd02b5";
	$id = "2625";
	$linktrust = new clsLinkTrustPartnerAPI($key, $id);

	//Crush Constant Contact
	$affiliate_id = 276928;
	$rev = (double)str_replace("$","",(string)$linktrust->GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id));
	$total = $total + $rev;
	$result_data[] = array("system" => "Crush Constant Contact", "revenue" => $rev );

	//Linktrust (volo)
	$affiliate_id = 276542;
	$rev =(double) str_replace("$","",(string)$linktrust->GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id));
	$total = $total + $rev;
	$result_data[] = array("system" => "Crush VoloMP", "revenue" => $rev );

	$formatted_total = number_format($total,2);
	//echo "<strong>BMI Total: $$formatted_total <br/></strong>";

}

else if ($mailer == "7Above")
{
	$total2 = 0.00;
	//echo "<br/<br/>7Above<br/>------------------------<br/>";

	//Clickbooth for 7
	$domain_name = "affiliates.clickbooth.com";
	$api_key = 'p3JpiSzZszNNOhhE9jTvcA';
	$aff_id = '836935';
	$cake = new clsCakeApiPlugin($domain_name, $api_key, $aff_id);
	$rev = (double)$cake->GetRevenueForTimePeriod($start_date, $end_date);
	$result_data[] = array("system" => "Clickbooth", "revenue" => $rev );

	$total2 = $rev;

	//Adstation Robomail
	$token = "969f1647cf308ac5c0d81209264d849d";
	$adstation = new clsAdstationApiPlugin($token);
	$guid = 4795;
	$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
	$result_data[] = array("system" => "Adstation Robomail", "revenue" => $rev );

	$total2 = $total2 + $rev;

	//Adstation Volo
	$token = "969f1647cf308ac5c0d81209264d849d";
	$adstation = new clsAdstationApiPlugin($token);
	$guid = 4919;
	$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
	//$rev = "0.00";
	$result_data[] = array("system" => "Adstation VoloMP", "revenue" => $rev );

	$total2 = $total2 + $rev;

	$key = "5f202f8c-3d32-48d3-b84b-654f62fd02b5";
	$id = "2625";
	$linktrust = new clsLinkTrustPartnerAPI($key, $id);

	$affiliate_id = 275140;
	$rev = (double)str_replace("$","",(string)$linktrust->GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id));
	$total2 = $total2 + $rev;
	$result_data[] = array("system" => "Crush", "revenue" => $rev );

	$formatted_total2 = number_format($total2,2);
	//echo "<strong>7Above Total: $$formatted_total2 <br/></strong><br/><br/><br/>";
}





header("Content-type: application/json");
echo "{\"data\":" .json_encode($result_data). "}";