<?php
	include '../../../../private/initialize.php';

	$medicine = new Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['available_medicines'] as $available_medicines) {
		foreach ($data['transactions'] as $transactions) {
			if($available_medicines['supplier_medicine_id'] == $transactions['id']) {
				if($available_medicines['barangay_id'] == $_SESSION['barangay_id']) {

					$medicine->medicine_id = $available_medicines['medicine_id'];

					$medicine->supplier_medicine_id = $available_medicines['supplier_medicine_id'];

					$medicine->quantity = $available_medicines['quantity'] - $transactions['quantity'];

					$medicine->status = $available_medicines['status'];

					$medicine->barangay_id = $available_medicines['barangay_id'];


					$medicine->updateMedicine();
				}
			}
		}
	}