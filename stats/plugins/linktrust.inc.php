<?php

class clsLinkTrustAPI
{

	private $key;
	private $id;

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

	public function GetRevenueForTimePeriod($start_date, $end_date)
	{
		$start_date = urlencode($start_date);
		$end_date = urlencode($end_date);

		date_default_timezone_set("UTC");
		$utc_date = date("YmdHi");
		$hash = "/rest/" . $this->id . "/reports/affiliatecentercampaignperformance" . $utc_date . $this->key;
		$token = $utc_date . "_" . strtoupper(md5($hash));


		$url = "https://integration.beta.linktrust.com/rest/" . $this->id . "/Reports/AffiliateCenterCampaignPerformance?token=" . $token . "&DateFrom=$start_date&DateTo=$end_date";
		$result = $this->MakeRequest($url);

		$my_stats = new SimpleXMLElement($result);

		$rev = $my_stats->Affiliate->Statistics->Commission;
		return $rev;
	}
}