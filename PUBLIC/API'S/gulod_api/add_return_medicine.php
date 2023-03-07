<?php
	include '../../../private/initialize.php';

	$return_medicine = new Return_Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	$return_medicine->return_medicine_id = $data['return_medicine_id'];
	$return_medicine->beneficiary_id = $data['beneficiary_id'];
	$return_medicine->user_id = $_SESSION['user_id'];
	$return_medicine->transaction_id = $data['transaction_id'];
	$return_medicine->date_return = $data['date_return'];


	$_SESSION['return_medicine_id'] = $return_medicine->return_medicine_id;

	$return_medicine->addReturnMedicine();