<?php
	include '../../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['transactions'] as $transactions) {
		foreach ($data['available_medicines'] as $available_medicines) {
			if($transactions['id'] == $available_medicines['received_order_details_id']) {

				$received_order_details->received_order_details_id = $available_medicines['received_order_details_id'];

				$received_order_details->quantity = $available_medicines['quantity'] - $transactions['quantity'];

				$received_order_details->updateReceivedOrderDetails();
			}
		}
	}

	