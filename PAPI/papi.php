<?php
/**
* PAPI Class
* Version 1.0.0
*
* @Author Matt Kent
* License: QPL
*/
require_once 'abstract_papi.php';

class PAPI {

	protected $api_key;

	protected $user;

	public function __construct($request, $origin) {
		parent::__construct($request);

		$this->api_key = new Core\APIKey();

		if (!array_key_exists('apiKey', $this->request)) {
			throw new Exception('No API Key provided');
		}
		else if (!$this->api_key->verify($this->request['apiKey'], $origin)) {
			throw new Exception('Invalid API Key');
		}

		$this->user = new Core\User();
	}

	protected function example() {
		if ($this->method == 'GET') {
			return 'Name is john';
		}
		else {
			return 'Only accepts GET requests';
		}
	}
}