<?php

	include '../../../../../private/initialize.php';

	$dependent = new Dependent();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['dependents'] as $dependents) {
		if($dependents['beneficiary_id'] == $data['beneficiary_id']) {
			$dependent->dependent_id =  $dependents['dependent_id'];
			$dependent->status = "Not Active";
			$dependent->beneficiary_id = "";

			$dependent->deactivateAndNoBeneficiaryDependent();
		}
	}

	

	