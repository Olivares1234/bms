<?php
	include '../../../private/initialize.php';

	$medicine = new Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['medicines'] as $gulod_medicine) {
		if($gulod_medicine['supplier_medicine_id'] == $data['supplier_medicine_id']) {
			if($gulod_medicine['barangay_id'] == $data['barangay_id']) {

				$medicine->medicine_id = $gulod_medicine['medicine_id'];
				$medicine->supplier_medicine_id = $gulod_medicine['supplier_medicine_id'];
				$medicine->quantity = $gulod_medicine['quantity'] + $data['quantity'];
				$medicine->status = $gulod_medicine['status'];
				$medicine->barangay_id = $gulod_medicine['barangay_id'];


				$medicine->updateMedicine();
			}
		}
	}