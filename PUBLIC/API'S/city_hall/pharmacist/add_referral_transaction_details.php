<?php
	include '../../../../private/initialize.php';

	$referral_transaction_details = new Referral_Transaction_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['transactions'] as $transactions) {
		
		$referral_transaction_details->referral_transaction_id = $_SESSION['referral_transaction_id'];

		$referral_transaction_details->purchase_received_details_id = $transactions['id'];

		$referral_transaction_details->quantity = $transactions['quantity'];

		$referral_transaction_details->price = $transactions['price'];

		$referral_transaction_details->total_price = $transactions['total_amount'];

		$referral_transaction_details->addReferralTransactionDetails();
	}

	
		
	

