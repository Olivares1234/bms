<?php

	include '../../../../private/initialize.php';

	$transaction_details = new Transaction_Details();
	
	echo json_encode($transaction_details->retrieveTransactionDetailsForReturn($_SESSION['barangay_id'], $_GET['transaction_id']));