<?php
	include '../../../../private/initialize.php';

	$purchase_received_details = new Purchase_Received_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['transactions'] as $transactions) {
		foreach ($data['available_medicines'] as $available_medicines) {

			if($transactions['id'] == $available_medicines['purchase_received_details_id']) {

				$purchase_received_details->purchase_received_details_id = $transactions['id'];

				$purchase_received_details->received_quantity = $available_medicines['received_quantity'] - $transactions['quantity'];

				$purchase_received_details->updatePurchaseReceivedDetails();
			}
		}
	}


	