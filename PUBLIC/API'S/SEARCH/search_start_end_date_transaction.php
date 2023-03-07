<?php

	include '../../../private/initialize.php';

	$transaction_details = new Transaction_Details();
	
	echo json_encode($transaction_details->getBeneficiaryTransactionStartEndDate($_SESSION['beneficiary_id'], $_GET['start_date'], $_GET['end_date']));