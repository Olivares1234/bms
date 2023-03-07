<?php
	include '../../../private/initialize.php';

	$user = new User();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['username'])) {
		$response['username_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['password'])) {
		$response['password_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['first_name'])) {
		$response['first_name_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['last_name'])) {
		$response['last_name_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['middle_name'])) {
		$response['middle_name_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['contact_no'])) {
		$response['contact_no_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['birth_date'])) {
		$response['birth_date_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['email_address'])){
		$response['email_address_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['sex'])) {
		$response['sex_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['address'])) {
		$response['address_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['is_employed'])) {
		$response['is_employed_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['barangay_id'])) {
		$response['barangay_id_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['user_type_id'])) {
		$response['user_type_id_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if($response['status'] == "NOT_OK") {
		echo json_encode($response);
	} else {
		$user = new User();
		
		$response['status'] = "OK";

		echo json_encode($response);


		echo json_encode($response);
		$user->username = $data['username'];
		$user->password = $data['password'];
		$user->first_name = $data['first_name'];
		$user->last_name = $data['last_name'];
		$user->middle_name = $data['middle_name'];
		$user->contact_no = $data['contact_no'];
		$user->birth_date = $data['birth_date'];
		$user->email_address = $data['email_address'];
		$user->sex = $data['sex'];
		$user->address = $data['address'];
		$user->is_employed = $data['is_employed'];
		$user->barangay_id = $data['barangay_id'];
		$user->user_type_id = $data['user_type_id'];

		$user->addUser();
	}
	
		
	

