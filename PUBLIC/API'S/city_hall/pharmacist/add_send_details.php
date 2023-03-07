a<?php
	include '../../../../private/initialize.php';

	$send_details = new Send_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['request_details'] as $request_detail) {
		$send_details->send_order_id = $_SESSION['send_order_id'];
		$send_details->purchase_received_details_id = $request_detail['purchase_received_details_id'];
		$send_details->quantity = $request_detail['delivered_quantity'];
		$send_details->received_quantity = "0";


		$send_details->addSendDetails();
	}

