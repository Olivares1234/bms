<?php
	include '../../../../../private/initialize.php';

	$dependent = new Dependent();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['fullname'])) {
		$response['fullname_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['sex'])) {
		$response['sex_error'] = true;
		$response['status'] = "NOT_OK";
	}


	if(empty($data['educational_attainment'])) {
		$response['educational_attainment_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['occupation'])) {
		$response['occupation_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['beneficiary_id'])) {
		$response['beneficiary_id_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if($response['status'] == "NOT_OK") {
		echo json_encode($response);
	} else {
		$dependent = new Dependent();
		
		$response['status'] = "OK";

		echo json_encode($response);

		$dependent->dependent_id = $data['dependent_id'];
		$dependent->fullname = $data['fullname'];
		$dependent->sex = $data['sex'];
		$dependent->educational_attainment = $data['educational_attainment'];
		$dependent->occupation = $data['occupation'];
		$dependent->beneficiary_id = $data['beneficiary_id'];

		$dependent->updateDependent();
	}

	

	