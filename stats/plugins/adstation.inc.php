<?php
require_once 'libs/curl.inc.php';

class clsAdstationApiPlugin
{

	private $token;

	public function __construct($token)
	{
		$this->token = $token;

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

	public function GetRevenueForTimePeriod($start_date, $end_date, $product_guid="*")
	{
		$start_date = urlencode($start_date);
		$end_date = urlencode($end_date);

		$url = "https://api.publisher.adknowledge.com/performance.xml?token=" . $this->token . "&product_id=2&product_guid=$product_guid&dimensions=revenue_type&measures=revenue&start_date=$start_date&end_date=$end_date&limit=0&format=xml";

		$result = $this->MakeRequest($url);

		try {
			$my_stats = new SimpleXMLElement($result);
		}

		 catch (Exception $e)
		{
			return null;
		}
		$rev = $my_stats->data->record->revenue;
		return $rev;

	}
}

?>