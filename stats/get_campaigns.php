<?php
require_once 'plugins/linktrust_partner.inc.php';
require_once 'libs/curl.inc.php';

$key = "5f202f8c-3d32-48d3-b84b-654f62fd02b5";
$id = "2625";
$linktrust = new clsLinkTrustPartnerAPI($key, $id);

$campaigns = $linktrust->GetCampaigns();

header("Content-type: application/json");
echo "{\"data\":" .json_encode($campaigns). "}";