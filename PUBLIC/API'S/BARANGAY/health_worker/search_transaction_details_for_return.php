<?php

	include '../../../../private/initialize.php';

	$transaction_details = new Transaction_Details();
	
	echo json_encode($transaction_details->searchTransactionDetailsForReturn($_GET['filter'], $_GET['keyword'], $_GET['transaction_id']));