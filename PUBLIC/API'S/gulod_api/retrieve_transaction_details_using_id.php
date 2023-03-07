<?php

	include '../../../private/initialize.php';

	$transaction_details = new Transaction_Details();
	
	echo json_encode($transaction_details->retrieveTransactionDetails($_GET['transaction_id']));