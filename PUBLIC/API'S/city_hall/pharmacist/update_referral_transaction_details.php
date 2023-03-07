<?php
	include '../../../../private/initialize.php';

	$referral_transaction_details = new Referral_Transaction_Details();

	$data = json_decode(file_get_contents("php://input"),true);



	foreach ($data['referral_details'] as $referral_details) {

		if($referral_details['referral_transaction_details_id'] == $data['referral_transaction_details_id']) {


			$referral_transaction_details->referral_transaction_details_id = $referral_details['referral_transaction_details_id'];

			$referral_transaction_details->referral_transaction_id = $referral_details['referral_transaction_id'];

			$referral_transaction_details->purchase_received_details_id = $referral_details['purchase_received_details_id'];

			$referral_transaction_details->quantity = $referral_details['quantity'] - $data['quantity'];

			$referral_transaction_details->price = $referral_details['price'];

			$referral_transaction_details->total_price = $referral_transaction_details->quantity * $referral_transaction_details->price;

			$referral_transaction_details->updateReferralTransactionDetails();

			
		}

		
	}

	
		
	

