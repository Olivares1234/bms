<?php
	include '../../../../private/initialize.php';

	$purchase_received_details = new Purchase_Received_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['request_details'] as $request_details) {
		foreach ($data['available_medicines'] as $available_medicines) {
			if($request_details['purchase_received_details_id'] == $available_medicines['purchase_received_details_id']) {
				$purchase_received_details->purchase_received_details_id = $request_details['purchase_received_details_id'];

				$purchase_received_details->received_quantity = $available_medicines['received_quantity'] - $request_details['delivered_quantity'];

				$purchase_received_details->updatePurchaseReceivedDetails();
			}
		}
	}


	