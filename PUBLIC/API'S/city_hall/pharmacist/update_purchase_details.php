<?php
	include '../../../../private/initialize.php';

	$purchase_details = new Purchase_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['purchase_order_details'] as $purchase_order_details) {
		if($data['purchase_details_id'] == $purchase_order_details['purchase_details_id']) {
			if($data['supplier_medicine_id'] == $purchase_order_details['supplier_medicine_id']) {

				$purchase_details->purchase_details_id = $purchase_order_details['purchase_details_id'];
				$purchase_details->purchase_order_id = $purchase_order_details['purchase_order_id'];
				$purchase_details->supplier_medicine_id = $purchase_order_details['supplier_medicine_id'];
				$purchase_details->quantity = $purchase_order_details['quantity'];
				$purchase_details->received_quantity = $data['received_quantity'] + $purchase_order_details['received_quantity'];

				$purchase_details->updatePurchaseDetails();

			}
		}
	}

	