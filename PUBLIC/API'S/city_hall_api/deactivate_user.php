<?php
	include '../../../private/initialize.php';
	
	$user = new User();

	$data = json_decode(file_get_contents("php://input"),true);

	$user->user_id = $data['user_id'];
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

	$user->updateUser();