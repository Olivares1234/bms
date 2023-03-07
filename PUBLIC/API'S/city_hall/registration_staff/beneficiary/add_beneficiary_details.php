<?php
	include '../../../../../private/initialize.php';

	$beneficiary_details = new Beneficiary_Details();

	$data = json_decode(file_get_contents("php://input"),true);


	$beneficiary_details->beneficiary_id = $_SESSION['beneficiary_id'];
	$beneficiary_details->user_id = $_SESSION['user_id'];
	$beneficiary_details->date_added = $data['date_added'];

	$beneficiary_details->addBeneficiaryDetails();

	

	