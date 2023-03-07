<?php
	include '../../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

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
		$response['contact_no_description'] = "This field is required!";
		$response['status'] = "NOT_OK";
	}

	if(strlen($data['contact_no']) != 11) {
		$response['contact_no_error'] = true;
		$response['contact_no_description'] = "Invalid phone number!";
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
	else if($data['birth_day'] > 31 || $data['birth_day'] == 0) {
		$response['birth_day_error'] = true;
		$response['birth_day_description'] = "Invalid day!";
		$response['status'] = "NOT_OK";
	}

	if(empty($data['birth_year'])) {
		$response['birth_year_error'] = true;
		$response['birth_year_description'] = "This field is required!";
		$response['status'] = "NOT_OK";
	}
	else if($data['birth_year'] < "1899" || $data['birth_year'] > date('Y')) {
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

	if(empty($data['street'])) {
		$response['street_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['house_no'])) {
		$response['house_no_error'] = true;
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

	if(empty($data['religion'])) {
		$response['religion_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['civil_status_id'])) {
		$response['civil_status_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['barangay_id'])) {
		$response['barangay_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['voters_id'])) {
		$response['voters_id_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if($response['status'] == "NOT_OK") {
		echo json_encode($response);
	} else {
		$beneficiary = new Beneficiary();
		
		$response['status'] = "OK";

		echo json_encode($response);

		$beneficiary->beneficiary_id = $data['beneficiary_id'];
		$beneficiary->first_name = $data['first_name'];
		$beneficiary->last_name = $data['last_name'];
		$beneficiary->middle_name = $data['middle_name'];
		$beneficiary->contact_no = $data['contact_no'];
		$beneficiary->birth_date = $data['birth_year'] . '-' . $data['birth_month'] . '-' . $data['birth_day'];
		$beneficiary->email_address = $data['email_address'] . $data['email_extension'];
		$beneficiary->sex = $data['sex'];
		$beneficiary->address = $data['house_no'] . ', ' . $data['street'] . ', ' . $data['subdivision'];
		$beneficiary->educational_attainment = $data['educational_attainment'];
		$beneficiary->occupation = $data['occupation'];
		$beneficiary->religion = $data['religion'];
		$beneficiary->civil_status_id = $data['civil_status_id'];
		$beneficiary->status = "Not Active";
		$beneficiary->beneficiary_type_id = '5';
		$beneficiary->balance = '0';
		$beneficiary->barangay_id = $data['barangay_id'];
		$beneficiary->voters_id = $data['voters_id'];
		$beneficiary->is_dependent = "0";


		$_SESSION['beneficiary_id'] = $beneficiary->beneficiary_id;
		$beneficiary->addBeneficiary();
	}

	

	