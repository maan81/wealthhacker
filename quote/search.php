<?php

// print_r($_GET);
session_start();

require('../config/config.php');
require('../include/functions.php');
require('../include/db.php');


$s = $_GET['symbol'];

// if invalid symbol, retirect to homepage
if(!validate($s)){
	$_SESSION['error'] = "Invalid Symbol";
// print_r($_SESSION);die;
	header('Location: '.$config['baseurl']);
	die;
}

// init db access
$db = new Database($config['db']);


// make sure the symbol exists in the db
$data = $db->get($config['db']['table_queries'],' AND symbol="'.$s.'" AND name!="" ');

// symbol not present in db ...
if(count($data)!=1){
	// redirect to homepage (or can be modified to a 404 page)
	$_SESSION['error'] = "Invalid Symbol";
// print_r($_SESSION);die;
	header('Location: '.$config['baseurl']);
	die;
}


// redirect to the symbol page
header('Location: '.$config['baseurl'].'/quote/'.$s);

