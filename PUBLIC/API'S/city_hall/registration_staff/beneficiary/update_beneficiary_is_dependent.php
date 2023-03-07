<?php

	include '../../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['dependents'] as $dependents) {
		foreach ($data['beneficiaries'] as $beneficiaries) {
			if($dependents['beneficiary_id'] == $data['beneficiary_id']) {
				if($dependents['voters_id'] == $beneficiaries['voters_id']) {
					$beneficiary->beneficiary_id = $beneficiaries['beneficiary_id'];
					$beneficiary->is_dependent = '0';

					$beneficiary->updateBeneficiaryIsDependent();
				}
			}
		}
	}

	

	