<?php

	include '../../../../private/initialize.php';

	$referral_details = new Referral_Transaction_Details();
	
	echo json_encode($referral_details->searchReferralTransactionDetails($_GET['referral_transaction_id'], $_GET['filter'], $_GET['keyword']));