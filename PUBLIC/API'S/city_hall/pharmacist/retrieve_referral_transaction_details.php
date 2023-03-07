<?php

	include '../../../../private/initialize.php';

	$referral_transaction_details = new Referral_Transaction_Details();

	echo json_encode($referral_transaction_details->retrieveReferralTransactionDetails($_GET['referral_transaction_id']));