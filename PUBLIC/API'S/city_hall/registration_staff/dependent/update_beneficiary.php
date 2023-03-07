<?php
	include '../../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['addDependents'] as $addDependents) {
		
		$beneficiary->voters_id = $addDependents['voters_id'];

		$beneficiary->beneficiaryIsDependent();
	}

	

	

	