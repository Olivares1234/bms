<?php
	include '../../../../private/initialize.php';

	$return_referral_medicine = new Return_Referral_Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	$return_referral_medicine->return_referral_medicine_id = $data['return_referral_medicine_id'];
	$return_referral_medicine->beneficiary_id = $data['beneficiary_id'];
	$return_referral_medicine->user_id =  $_SESSION['user_id'];
	$return_referral_medicine->referral_transaction_id = $data['referral_transaction_id'];
	$return_referral_medicine->return_referral_date = $data['return_referral_date'];
	
	$_SESSION['return_referral_medicine_id'] = $return_referral_medicine->return_referral_medicine_id;

	$return_referral_medicine->addReturnReferralMedicine();