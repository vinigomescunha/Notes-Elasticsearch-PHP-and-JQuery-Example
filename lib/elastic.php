<?php
/*
vinicius Gomes
vinigomescunha at gmail.com
*/
require 'vendor/autoload.php';
require 'constants.php';
Class Elastic {

	protected $client;
	protected $hosts = ['127.0.0.1:9200', '127.0.1.1:9200'];
	/**
	params fields
		[fields] - receive POST fields
		[doc] - receive array of param of documents
	*/
	public $params = [];

	function __construct() {
		//https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_configuration.html
		$this->client = Elasticsearch\ClientBuilder::create()->setHosts($this->hosts)->build();
		$this->params = [
			'args' => $_GET, 
			'fields' => filter_input(INPUT_POST, 'fields', FILTER_SANITIZE_STRING , FILTER_REQUIRE_ARRAY)
		];
	}

	/**
	Create the index to elasticsearch work if not exists
	https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_index_management_operations.html
	*/

	public function createIndex() {
		$index = ['index' => INDEX ]; 
		$r = "";   
		try {
			if(!$this->client->indices()->exists( $index )) {
				$r = $this->client->indices()->create( $index );
			}
		} catch(Exception $exception) {
			$r = ['error' => $exception->getMessage()];
		}
		return json_encode($r);
	}

	/**
	Search documents 
	https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_search_operations.html
	*/

	public function searchDoc() {
		
		$params = [
			'index' => INDEX,
			'type' => TYPE,
			'body' => [], 
			'size' => $this->params['args']['size'],
			'from' => $this->params['args']['from']
		];
		foreach($this->params['args']['q'] as $k => $q) {
			$params['body']['query']['filtered']['filter']['term'][$k] = "$q";
		}
		try {
			$r = $this->client->search($params);
			
		} catch(Exception $exception) {
			$r = [ 'error' => $exception->getMessage() ];
		}
		return json_encode($r);
	}

	/**
	Index document
	https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_indexing_documents.html
	*/

	public function indexDoc() {

		$params = [
			'index' => INDEX,
			'type' => TYPE,
			'body' => []	
			];
		foreach($this->params['fields'] as $k => $q) {
			$params['body'][$k] = "$q";
		}
		try {
			$r = $this->client->index($params);
		} catch(Exception $exception) {
			$r = [ 'error' => $exception->getMessage() ];
		}
		return json_encode($r);
	}

	/**
	Get specific document by id
	https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_getting_documents.html
	*/

	public function getDoc() {

		$params = [
			'index' => INDEX,
			'type' => TYPE,
			'id' => $this->params['args']['id']
		];
		try {
			$r = $this->client->get($params);
		} catch(Exception $exception) {
			$r = [ 'error' => $exception->getMessage() ];
		}
		return json_encode($r);
		
	}

	/**
	update document by id 
	https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_updating_documents.html
	*/

	public function updateDoc() {
		
		$params = [
		'index' => INDEX,
		'type' => TYPE,
		'id' => $this->params['args']['id'],
		'body' => [
			'doc' => []
			]
		];
		foreach($this->params['fields'] as $k => $q) {
			$params['body']['doc'][$k] = "$q";
		}
		try { 
			$r = $this->client->update($params);
		} catch(Exception $exception) {
			$r = [ 'error' => $exception->getMessage() ];
		}
		return json_encode($r);
	}

	/**
	delete document by id 
	https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_deleting_documents.html
	*/

	public function deleteDoc() {
		
		$params = [
			'index' => INDEX,
			'type' => TYPE,
			'id' => $this->params['args']['id']
		];
		try {
			$r = $this->client->delete($params);
			
		} catch(Exception $exception) {
			$r = [ 'error' => $exception->getMessage() ];
		}
		return json_encode($r);
	}
}
