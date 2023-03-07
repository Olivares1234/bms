<?php
	include '../../../../private/initialize.php';

	$referral_transaction = new Referral_Transaction();

	$data = json_decode(file_get_contents("php://input"),true);

	$referral_transaction->referral_transaction_id = $data['referral_transaction_id'];
	$referral_transaction->beneficiary_id = $data['beneficiary_id'];
	$referral_transaction->user_id = $_SESSION['user_id'];
	$referral_transaction->referral_transaction_date = $data['referral_transaction_date'];
	$referral_transaction->barangay_id = $data['barangay_id'];

	$_SESSION['referral_transaction_id'] = $referral_transaction->referral_transaction_id;

	$referral_transaction->addReferralTransaction();
	
		
	

