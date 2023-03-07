<?php
	include '../../../../../private/initialize.php';

	$beneficiary= new Beneficiary();

	$data = json_decode(file_get_contents("php://input"),true);


	$beneficiary->beneficiary_id = $data['beneficiary_id'];
	$beneficiary->status = "Not Active";

	$beneficiary->deactivateBeneficiary();

	

	