<?php
	include '../../../../private/initialize.php';
	
	$beneficiary = new Beneficiary();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['referral_details'] as $referral_details) {
		foreach ($data['beneficiaries'] as $beneficiaries) {
			if($referral_details['referral_transaction_details_id'] == $data['referral_transaction_details_id']) {
				 if($beneficiaries['beneficiary_id'] == $data['beneficiary_id']) {

				 	$beneficiary->beneficiary_id = $beneficiaries['beneficiary_id'];

				 	
			
					$beneficiary->balance = $beneficiaries['balance'] - ($data['quantity'] * $referral_details['price']);


					$beneficiary->updateBeneficiaryBalance();
				 }
			}
		}
	}
	
	
	