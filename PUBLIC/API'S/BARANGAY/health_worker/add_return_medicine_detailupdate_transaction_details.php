<?php
	include '../../../../private/initialize.php';

	$return_medicine_details = new Return_Medicine_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['quantity'])) {
		$response['return_medicine_quantity_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['remarks'])) {
		$response['return_medicine_remarks_error'] = true;
		$response['status'] = "NOT_OK";
	}
	else 
	{
		$return_medicine_details->return_medicine_id = $_SESSION['return_medicine_id'];

		$return_medicine_details->received_order_details_id = $data['received_order_details_id'];

		$return_medicine_details->quantity = $data['quantity'];

		$return_medicine_details->total_amount = $data['total_amount'];
		
		$return_medicine_details->remarks = $data['remarks'];

		$return_medicine_details->addReturnMedicineDetails();
	}

	