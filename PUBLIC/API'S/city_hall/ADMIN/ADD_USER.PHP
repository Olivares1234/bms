<?php
	include '../../../../private/initialize.php';

	$user = new User();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['first_name'])) {
		$response['first_name_error'] = true;
		$response['status'] = "NOT_OK";
	}
 
	if(empty($data['last_name'])) {
		$response['last_name_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['contact_no'])) {
		$response['contact_no_error'] = true;
		$response['contact_no_error'] = "This field is required!";
		$response['status'] = "NOT_OK";
	}

	if(strlen($data['contact_no']) != 11) {
		$response['contact_no_error'] = true;
		$response['contact_no_error'] = "Invalid Phone number!";
		$response['status'] = "NOT_OK";
	}

	if(empty($data['birth_month'])) {
		$response['birth_month_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['birth_day'])) {
		$response['birth_day_error'] = true;
		$response['birth_day_description'] = "This field is required!";
		$response['status'] = "NOT_OK";
	}

	if($data['birth_day'] > "31" || $data['birth_day'] == 0) {
		$response['birth_day_error'] = true;
		$response['birth_day_description'] = "Invalid day!";
		$response['status'] = "NOT_OK";
	}

	if(empty($data['birth_year'])) {
		$response['birth_year_error'] = true;
		$response['birth_year_description'] = "This field is required!";
		$response['status'] = "NOT_OK";
	}

	if($data['birth_year'] < "1899" || $data['birth_year'] > date('Y')) {
		$response['birth_year_error'] = true;
		$response['birth_year_description'] = "Birth year out of range!";
		$response['status'] = "NOT_OK";
	}

	if(empty($data['email_address'])) {
		$response['email_address_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['email_extension'])) {
		$response['email_extension_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['sex'])) {
		$response['sex_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['house_no'])) {
		$response['house_no_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['street'])) {
		$response['street_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['is_employed'])) {
		$response['is_employed_error'] = true;
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
		$user->password = "bms123";
		$user->first_name = $data['first_name'];
		$user->last_name = $data['last_name'];
		$user->middle_name = $data['middle_name'];
		$user->contact_no = $data['contact_no'];
		$user->birth_date = $data['birth_year'] . "-" . $data['birth_month'] . "-" . $data['birth_day'];
		$user->email_address = $data['email_address'] . $data['email_extension'];
		$user->sex = $data['sex'];
		$user->address = $data['house_no'] . ", " . $data['street'] . ", " . $data['subdivision'];
		$user->is_employed = $data['is_employed'];
		$user->barangay_id = "20";
		$user->user_type_id = "5";
		$user->default_password = "bms123";
		$user->date_added = $data['date_added'];

		$user->addUser();
	}
	
		
	

