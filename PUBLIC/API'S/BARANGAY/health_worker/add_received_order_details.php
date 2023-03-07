<?php
	include '../../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['quantity'])) {
		$response['received_order_quantity_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['expiration_month'])) {
		$response['expiration_month_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['expiration_day'])) {
		$response['expiration_day_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['expiration_year'])) {
		$response['expiration_year_error'] = true;
		$response['status'] = "NOT_OK";
	}
 
	if(empty($data['barcode'])) {
		$response['barcode_error'] = true;
		$response['status'] = "NOT_OK";
	}
	else 
	{
		$received_order_details = new Received_Order_Details();
		
		$response['status'] = "OK";

		echo json_encode($response);

		$received_order_details->received_order_id = $_SESSION['received_order_id'];
		$received_order_details->purchase_received_details_id = $data['purchase_received_details_id'];
		$received_order_details->quantity = $data['quantity'];
		$received_order_details->expiration_date = $data['expiration_year'] . "-" . $data['expiration_month'] . "-" . $data['expiration_day'];
		$received_order_details->status = $data['status'];
		$received_order_details->barcode = $data['barcode'];

		$received_order_details->addReceivedOrderDetails();
	}

	