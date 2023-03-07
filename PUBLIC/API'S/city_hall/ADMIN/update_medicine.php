<?php
	include '../../../../private/initialize.php';

	$medicine = new Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['medicines'] as $new_medicine) {
		foreach ($data['request_details'] as $request_detail) {
			if($new_medicine['supplier_medicine_id'] == $request_detail['supplier_medicine_id']) {
				$medicine->medicine_id = $new_medicine['medicine_id'];
				$medicine->supplier_medicine_id = $new_medicine['supplier_medicine_id'];
				$medicine->quantity = $new_medicine['quantity'] - $request_detail['delivered_quantity'];
				$medicine->status = $new_medicine['status'];
				$medicine->barangay_id = $new_medicine['barangay_id'];

				$medicine->updateMedicine();
			}
		}
	}

	
	
	
	
	

	