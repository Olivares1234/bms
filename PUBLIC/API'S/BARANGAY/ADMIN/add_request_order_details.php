<?php
	include '../../../../private/initialize.php';

	$request_order_details = new Request_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['request_medicines'] as $request_medicine) {
		$request_order_details->request_order_id = $_SESSION['request_order_id'];
		$request_order_details->purchase_received_details_id = $request_medicine['purchase_received_details_id'];


		$request_order_details->addRequestOrderDetails();
	}