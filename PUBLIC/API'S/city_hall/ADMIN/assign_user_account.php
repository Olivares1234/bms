<?php
	include '../../../../private/initialize.php';
	
	$user = new User();

	$data = json_decode(file_get_contents("php://input"),true);

	$response['status'] = "OK";

	if(empty($data['user_id'])) {
		$response['status'] = "NOT_OK";
	}

	if(empty($data['barangay_id'])) {
		$response['status'] = "NOT_OK";
		$response['barangay_error'] = true;
	}

	if(empty($data['user_type_id'])) {
		$response['status'] = "NOT_OK";
		$response['user_type_error'] = true;
	}

	if($response['status'] == "NOT_OK") {
		echo json_encode($response);
	}
	else {
		$user = new User();

		$response['status'] = "OK";

		echo json_encode($response);

		$user->user_id = $data['user_id'];
		$user->barangay_id = $data['barangay_id'];
		$user->user_type_id = $data['user_type_id'];

		$user->assignUserAccount();
	}

	