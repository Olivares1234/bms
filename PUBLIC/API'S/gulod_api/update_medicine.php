<?php
	include '../../../private/initialize.php';

	$medicine = new Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['gulod_transactions'] as $gulod_transaction) {
		foreach ($data['gulod_medicines'] as $gulod_medicine) {
			if($gulod_transaction['id'] == $gulod_medicine['supplier_medicine_id']) {
				$medicine->medicine_id = $gulod_medicine['medicine_id'];
				$medicine->supplier_medicine_id = $gulod_medicine['supplier_medicine_id'];
				$medicine->quantity = $gulod_medicine['quantity'] - $gulod_transaction['quantity'];
				$medicine->status = $gulod_medicine['status'];
				$medicine->barangay_id = $gulod_medicine['barangay_id'];

				$medicine->updateMedicine();
			}
		}
	}