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

		$user->transferUser();
	}

	