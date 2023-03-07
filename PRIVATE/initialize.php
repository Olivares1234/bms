<?php

ob_start();
session_start();

	define("PRIVATE_PATH", dirname(__FILE__));
	define("PROJECT_PATH", dirname(PRIVATE_PATH));
	define("PUBLIC_PATH", PROJECT_PATH . '/public');
	define("SHARED_PATH", PRIVATE_PATH . '/shared');

	$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
	$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
	define("WWW_ROOT", $doc_root);

	require_once('function.php');
	require_once('config.php');
	require_once('classes/Database.php');
	require_once('classes/User.php');
	require_once('classes/User_Type.php');
	require_once('classes/Barangay.php');
	require_once('classes/Category.php');
	require_once('classes/Unit_Category.php');
	require_once('classes/Medicine.php');
	require_once('classes/Beneficiary.php');
	require_once('classes/Dependent.php');
	require_once('classes/Transaction_Details.php');
	require_once('classes/Transaction.php');
	require_once('classes/Return_Medicine.php');
	require_once('classes/Return_Medicine_Details.php');
	require_once('classes/Received_Order.php');
	require_once('classes/Received_Order_Details.php');
	require_once('classes/Supplier.php');
	require_once('classes/Purchase_Order.php');
	require_once('classes/Purchase_Order_Details.php');
	require_once('classes/Supplier_Medicine.php');
	require_once('classes/Purchase_Received.php');
	require_once('classes/Purchase_Received_Details.php');
	require_once('classes/Validation.php');
	require_once('classes/Request_Order.php');
	require_once('classes/Request_Order_Details.php');
	require_once('classes/Purchase_Details.php');
	require_once('classes/Request_Details.php');
	require_once('classes/Send_Order.php');
	require_once('classes/Send_Order_Details.php');
	require_once('classes/Send_Details.php');
	require_once('classes/Civil_Status.php');
	require_once('classes/Beneficiary_Details.php');
	require_once('classes/Referral_Transaction.php');
	require_once('classes/Referral_Transaction_Details.php');
	require_once('classes/Return_Referral_Medicine.php');
	require_once('classes/Return_Referral_Medicine_Details.php');














?>