<?php
	include '../../../private/initialize.php';

	$send_order_details = new Send_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['request_details'] as $request_detail) {

		$send_order_details->send_order_id = $_SESSION['send_order_id'];
		$send_order_details->supplier_medicine_id = $request_detail['supplier_medicine_id'];
		$send_order_details->quantity = $request_detail['delivered_quantity'];
		
		$send_order_details->addSendOrderDetails();
	}

	