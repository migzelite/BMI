<?php

class clsLinkTrustPartnerAPI
{
	private $key;
	private $id;

	private $my_stats;

	public function __construct($key, $id)
	{
		$this->key = $key;
		$this->id = $id;
	}

	private function MakeRequest($request)
	{
		$curl = new CURL();

		$opts = array( CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_SSL_VERIFYPEER => false );
		$curl->addSession( $request, $opts );
		$result = $curl->exec();
		$curl->clear();


		return $result;
	}

	public function GetCampaigns()
	{
		date_default_timezone_set("UTC");
		$utc_date = date("YmdHi");
		$hash = "/rest/" . $this->id . "/reports/advertised" . $utc_date . $this->key;
		$token = $utc_date . "_" . strtoupper(md5($hash));


		$url = "https://integration.beta.linktrust.com/rest/" . $this->id . "/reports/advertised?token=" . $token . "&DateFrom=$start_date&DateTo=$end_date";
		$result = $this->MakeRequest($url);

		$campaigns = new SimpleXMLElement($result);

		$campaign_array = array();
		foreach ($campaigns->Campaign as $campaign)
		{
			$campain_id = $campaign->attributes()->ID;
			$campaign_name = $campaign->attributes()->OfferTitle;

			$values = new stdClass();
			$values->campaign_id = (string)$campain_id;
			$values->campaign_name = (string)$campaign_name;
			$campaign_array[] = $values;

		}

		return $campaign_array;
	}

	public function GetStatsForCampaignForAffiliate($campaign_id, $affiliate_id, $start_date, $end_date)
	{
		if (!$this->my_stats)
		{
			$start_date = urlencode($start_date);
			$end_date = urlencode($end_date);

			date_default_timezone_set("UTC");
			$utc_date = date("YmdHi");
			$hash = "/rest/" . $this->id . "/reports/affiliateperformance" . $utc_date . $this->key;
			$token = $utc_date . "_" . strtoupper(md5($hash));


			$url = "https://integration.beta.linktrust.com/rest/" . $this->id . "/reports/affiliateperformance?token=" . $token . "&DateFrom=$start_date&DateTo=$end_date";
			$result = $this->MakeRequest($url);

			$this->my_stats = new SimpleXMLElement($result);
		}

		$my_stats = $this->my_stats;

		//Loop through each affiliate to find the one we want.
		foreach ($my_stats->Affiliate as $affiliate)
		{
			//Get the id of this affilaite.
			$id = $affiliate->attributes()->Id;

			//Check to see if this is the affiliate we are looking for.
			if ($id == $affiliate_id)
			{


				//Loop through the campaigns to find the one we are looking for.
				foreach ($affiliate->Campaigns->Campaign as $campaign)
				{

					$current_campign_id = $campaign->attributes()->Id;


					//See if this is the campaign we are looking for.
					if ($current_campign_id == $campaign_id)
					{

						$values = new stdClass();
						$values->campaign_name = (string)$campaign->attributes()->Name;
						$values->clicks = (string)$campaign->StatRow->Statistics->Clicks;
						$values->conversions = (string)$campaign->StatRow->Statistics->Approved;
						$values->conversion_percent = (string)$campaign->StatRow->Statistics->ApprovedPercentage;
						$values->epc = (string)$campaign->StatRow->Statistics->EPC;
						return $values;

					}
				}
			}
		}

	}

	public function GetRevenueForTimePeriod($start_date, $end_date, $affiliate_id)
	{
		$start_date = urlencode($start_date);
		$end_date = urlencode($end_date);

		date_default_timezone_set("UTC");
		$utc_date = date("YmdHi");
		$hash = "/rest/" . $this->id . "/reports/affiliateperformance" . $utc_date . $this->key;
		$token = $utc_date . "_" . strtoupper(md5($hash));


		$url = "https://integration.beta.linktrust.com/rest/" . $this->id . "/reports/affiliateperformance?token=" . $token . "&DateFrom=$start_date&DateTo=$end_date";
		$result = $this->MakeRequest($url);

		$my_stats = new SimpleXMLElement($result);

		//Loop through each affiliate to find the one we want.
		foreach ($my_stats->Affiliate as $affiliate)
		{
			//Get the id of this affilaite.
			$id = $affiliate->attributes()->Id;

			//Check to see if this is the affiliate we are looking for.
			if ($id == $affiliate_id)
			{
				$rev = $affiliate->Statistics->Revenue;
				return $rev;
			}

		}

		return "0.00";

	}
}