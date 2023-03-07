<?php
	include '../../../private/initialize.php';

	$request_order_details = new Request_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['request_orders'] as $request_order) {
		$request_order_details->request_order_id = $_SESSION['request_order_id'];
		$request_order_details->supplier_medicine_id = $request_order['medicine_id'];


		$request_order_details->addRequestOrderDetails();
	}