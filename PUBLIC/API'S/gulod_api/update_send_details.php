<?php

	include '../../../private/initialize.php';

	$send_details = new Send_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['send_details'] as $send_detail) {
		if($data['send_order_id'] == $send_detail['send_order_id']) {

			if($data['supplier_medicine_id'] == $send_detail['supplier_medicine_id']) {
				$send_details->send_details_id = $data['send_details_id'];
				$send_details->send_order_id = $data['send_order_id'];
				$send_details->supplier_medicine_id = $data['supplier_medicine_id'];
				$send_details->quantity = $data['quantity'];
				$send_details->received_quantity = $data['received_quantity'] + $send_detail['received_quantity'];

				$send_details->updateSendDetails();
			}
			
		}
	}

	


