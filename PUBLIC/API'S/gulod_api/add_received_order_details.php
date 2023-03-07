<?php
	include '../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['quantity'])) {
		$response['received_order_quantity_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['expiration_date'])) {
		$response['received_order_expiration_date_error'] = true;
		$response['status'] = "NOT_OK";
	}
	else 
	{
		$received_order_details = new Received_Order_Details();
		
		$response['status'] = "OK";

		echo json_encode($response);

		$received_order_details->received_order_id = $_SESSION['received_order_id'];
		$received_order_details->supplier_medicine_id = $data['supplier_medicine_id'];
		$received_order_details->quantity = $data['quantity'];
		$received_order_details->expiration_date = $data['expiration_date'];

		$received_order_details->addReceivedOrderDetails();
	}

	