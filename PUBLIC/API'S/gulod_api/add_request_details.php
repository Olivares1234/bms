<?php
	include '../../../private/initialize.php';

	$request_details = new Request_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['request_orders'] as $request_order) {
		$request_details->request_order_id = $_SESSION['request_order_id'];
		$request_details->supplier_medicine_id = $request_order['medicine_id'];
		$request_details->delivered_quantity = "0";


		$request_details->addRequestDetails();
	}