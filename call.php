<?php
header: header('Content-Type: text/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
require 'lib/elastic.php';

$e = new Elastic();
/* create index if not exists */
$e->createIndex();
/* get the action */
$act = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : ''; 

switch ($act) {
	case 'index':
		echo $e->indexDoc();
		break;
	case 'update':
		echo $e->updateDoc();
		break;
	case 'search':
		echo $e->searchDoc();
		break;
	case 'delete':
		echo $e->deleteDoc();
		break;
	case 'get':
		echo $e->getDoc();
		break;
}

