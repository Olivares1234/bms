<?php
	include '../../../../../private/initialize.php';

	$beneficiary_details = new Beneficiary_Details();

	$data = json_decode(file_get_contents("php://input"),true);


	$beneficiary_details->beneficiary_id = $data['beneficiary_id'];
	$beneficiary_details->user_id = $_SESSION['user_id'];
	$beneficiary_details->date_updated = $data['date_updated'];

	$beneficiary_details->updateBeneficiaryDetails();

	