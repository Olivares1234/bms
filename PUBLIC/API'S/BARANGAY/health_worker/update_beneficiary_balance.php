<?php
	include '../../../../private/initialize.php';
	
	$beneficiary = new Beneficiary();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['beneficiaries'] as $beneficiaries) {
		if($beneficiaries['beneficiary_id'] == $data['beneficiary_id']) {
			$beneficiary->beneficiary_id = $beneficiaries['beneficiary_id'];
			
			$beneficiary->balance = $beneficiaries['balance'] - ($data['quantity'] * $data['price']);


			$beneficiary->updateBeneficiaryBalance();
		}
	}

	
	
	