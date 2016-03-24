<?php

namespace App\Model;
 
use GuzzleHttp\Client;
use Nette\Object;
use Nette\Utils\Json;
use Nette\Utils\Strings;
use Tracy\Debugger;

class BitcoinPriceCalculator extends Object
{

	/** @var int */
	private $czkPerBitcoin;

	public function __construct()
	{
		$this->czkPerBitcoin = $this->readBitcoinPrice();
	}

	private function readBitcoinPrice()
	{
		$client = new Client([
			'base_uri' => 'https://api.bitcoinaverage.com/',
			'timeout'  => 2.0,
			'verify' => false
		]);
		$response = $client->request('GET', 'ticker/EUR/');
		$json = $response->getBody()->getContents();
		$data = Json::decode($json, true);
		$eurPricePerBitcoin = $data["24h_avg"];

		$client = new Client([
			'base_uri' => 'https://www.cnb.cz/',
			'timeout'  => 2.0,
			'verify' => false
		]);
		$response = $client->request('GET', 'cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt');
		$data = $response->getBody()->getContents();
		$czkPricePerEuro = Strings::match($data, '~\|EUR\|([0-9]+,[0-9]+)~')[0];
		$czkPricePerEuro = Strings::substring($czkPricePerEuro, Strings::length('|EUR|'));
		$czkPricePerEuro = (double) Strings::replace($czkPricePerEuro, '~,~', '.');

		return $czkPricePerEuro * $eurPricePerBitcoin;
	}

	public function getBitcoinPrice($czk)
	{
		return $czk / $this->czkPerBitcoin;
	}

}