<?php
include '../Login/config.php';
include '../Login/common.php';
include '../Login/users.php';
include '../Login/MenuBar.html';
//var_dump($_SESSION['valid']);
// Check if the user is logged in
//var_dump($_SESSION['valid']);
//echo cpm_stats;
$pos = strpos($_SESSION['valid'] ,text_stats);
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
require_once 'plugins/cake.inc.php';
require_once 'plugins/adstation.inc.php';
require_once 'plugins/linktrust.inc.php';
require_once 'plugins/linktrust_partner.inc.php';

$start_date = date("Y-m-d") . " 00:00:00";
//$start_date = "2013-07-01 00:00:00";
$end_date = date("Y-m-d") . " 23:59:59";
//$end_date = "2013-07-31 00:00:00";
$total = 0.00;

echo "BMI<br/>------------------------<br/>";

$domain_name = "affiliates.clickbooth.com";
$api_key = '2zb9bvOgUCsmomDO4lTIYQ';
$aff_id = '836303';
$cake = new clsCakeApiPlugin($domain_name, $api_key, $aff_id);
$rev = (string)$cake->GetRevenueForTimePeriod($start_date, $end_date);
echo "ClickBooth: $" . number_format($rev,2) . "<br/>";

$total = $rev;

$domain_name = "affiliates.clickbooth.com";
$api_key = '2zb9bvOgUCtMNS89tiWtQQ';
$aff_id = '836305';
$cake = new clsCakeApiPlugin($domain_name, $api_key, $aff_id);
$rev = (string)$cake->GetRevenueForTimePeriod($start_date, $end_date);
echo "ClickBooth LM: $" . number_format($rev,2) . "<br/>";

$total = $total + $rev;

//Adstation
$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
$adstation = new clsAdstationApiPlugin($token);
$guid = 5098;
$rev = (string)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
echo "Adstation DA: $" . number_format($rev,2) . "<br/>";

$total = $total + $rev;

//Adstation
$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
$adstation = new clsAdstationApiPlugin($token);
$guid = 4796;
$rev = (string)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
echo "Adstation1: $" . number_format($rev,2) . "<br/>";

$total = $total + $rev;

//Adstation
$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
$adstation = new clsAdstationApiPlugin($token);
$guid = 4931;
$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
echo "Adstation2: $" . number_format($rev,2) . "<br/>";

$total = $total + $rev;

//Adstation
$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
$adstation = new clsAdstationApiPlugin($token);
$guid = 4932;
$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
echo "Adstation3: $" . number_format($rev,2) . "<br/>";

$total = $total + $rev;

//Adstation
$token = "8b97bb810b5da8e5ad4bcb12f14fb3fd";
$adstation = new clsAdstationApiPlugin($token);
$guid = 4939;
$rev = (double)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
echo "Adstation4: $" . number_format($rev,2) . "<br/>";

$total = $total + $rev;


$key = "5f202f8c-3d32-48d3-b84b-654f62fd02b5";
$id = "2625";
$linktrust = new clsLinkTrustPartnerAPI($key, $id);

//Crush Constant Contact
$affiliate_id = 276928;
$rev = str_replace("$","",(string)$linktrust->GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id));
$total = $total + $rev;
echo "Crush (Constant Contact): $" . number_format($rev,2) . "<br/>";

//Linktrust (volo)
$affiliate_id = 276542;
$rev = str_replace("$","",(string)$linktrust->GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id));
$total = $total + $rev;
echo "Crush (VoloMP): $" . number_format($rev,2) . "<br/>";

//Linktrust (LM)
$affiliate_id = 277868;
$rev = str_replace("$","",(string)$linktrust->GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id));
$total = $total + $rev;
echo "Crush (LM): $" . number_format($rev,2) . "<br/><br/>";

$formatted_total = number_format($total,2);
echo "<strong>BMI Total: $$formatted_total <br/></strong>";

$total2 = 0.00;
echo "<br/<br/>7Above<br/>------------------------<br/>";

//Clickbooth for 7
$domain_name = "affiliates.clickbooth.com";
$api_key = 'p3JpiSzZszNNOhhE9jTvcA';
$aff_id = '836935';
$cake = new clsCakeApiPlugin($domain_name, $api_key, $aff_id);
$rev = (double)$cake->GetRevenueForTimePeriod($start_date, $end_date);
$result_data[] = array("system" => "Clickbooth", "revenue" => $rev );
echo "ClickBooth: $" . number_format($rev,2) . "<br/>";
$total2 = $rev;

//Adstation Robomail
$token = "969f1647cf308ac5c0d81209264d849d";
$adstation = new clsAdstationApiPlugin($token);
$guid = 4795;
$rev = (string)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
echo "Adstation (Robo): $" . number_format($rev,2) . "<br/>";

$total2 = $total2 + $rev;

//Adstation Volo
$token = "969f1647cf308ac5c0d81209264d849d";
$adstation = new clsAdstationApiPlugin($token);
$guid = 4919;
$rev = (string)$adstation->GetRevenueForTimePeriod($start_date, $end_date, $guid);
echo "Adstation (Volo): $" . number_format($rev,2) . "<br/>";

$total2 = $total2 + $rev;

$affiliate_id = 275140;
$rev = str_replace("$","",(string)$linktrust->GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id));
$total2 = $total2 + $rev;
echo "Crush: $" . number_format($rev,2) . "<br/><br/>";

$formatted_total2 = number_format($total2,2);
echo "<strong>7Above Total: $$formatted_total2 <br/></strong><br/><br/><br/>";

$grand_total = number_format($total + $total2, 2);
echo "<strong>Combined Total: $$grand_total <br/></strong><br/><br/><br/>";



