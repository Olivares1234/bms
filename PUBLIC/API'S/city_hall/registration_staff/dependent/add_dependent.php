<?php
	include '../../../../../private/initialize.php';

	$dependent = new Dependent();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['beneficiary_id'])) {
		$response['status'] = "NOT_OK";
	}

	if(empty($data['addDependents'])) {
		$response['status'] = "NOT_OK";
	}

	if($response['status'] == "NOT_OK") {
		echo json_encode($response);
	} else {
		$dependent = new Dependent();
		
		$response['status'] = "OK";

		echo json_encode($response);

		foreach ($data['addDependents'] as $addDependents) {
			 $dependent->fullname = $addDependents['fullname'];
			 $dependent->sex = $addDependents['sex'];
			 $dependent->civil_status_id = $addDependents['civil_status'];
			 $dependent->educational_attainment = $addDependents['educational_attainment'];
			 $dependent->occupation = $addDependents['occupation'];
			 $dependent->status = "Active";
			 $dependent->voters_id = $addDependents['voters_id'];
			$dependent->beneficiary_id = $data['beneficiary_id'];

			$dependent->addDependent();

		}
	}

	

	