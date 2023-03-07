<?php 

	include '../../../private/initialize.php';

	$transaction_details = new Transaction_Details();
	
	$transaction_details->transaction_id = $_GET['transaction_id'];
	$transaction_details->keyword = $_GET['keyword'];

	echo json_encode($transaction_details->searchTransactionDetails());