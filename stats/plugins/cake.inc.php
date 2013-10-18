<?php

require_once "libs/curl.inc.php";

class clsCakeApiPlugin
{
	private $domain_name;	//the domain name for the url to send the request to.
	private $api_key;		//The api key
	private $aff_id;		//The affiliate id.

	public function __construct($domain_name, $api_key, $aff_id)
	{
		$this->domain_name = $domain_name;
		$this->api_key = $api_key;
		$this->aff_id = $aff_id;
	}

	private function MakeRequest($request)
	{
		$curl = new CURL();

		$opts = array( CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true);
		$curl->addSession( $request, $opts );
		$result = $curl->exec();
		$curl->clear();

		return $result;
	}

	public function GetRevenueForTimePeriod($start_date, $end_date)
	{
		$start_date = urlencode($start_date);
		$end_date = urlencode($end_date);

		//Make the url for the request.
		$url = "http://" . $this->domain_name . "/affiliates/api/4/reports.asmx/CampaignSummary?api_key=" . $this->api_key . "&affiliate_id=" . $this->aff_id . "&start_date=$start_date&end_date=$end_date&sub_affiliate=&start_at_row=1&row_limit=0&sort_field=offer_name&sort_descending=true";


		$result = $this->MakeRequest($url);

		try {
			$my_campaings = new SimpleXMLElement($result);
		} catch (Exception $e)
		{
			return null;
		}

		return $my_campaings->summary->revenue;



	}

}