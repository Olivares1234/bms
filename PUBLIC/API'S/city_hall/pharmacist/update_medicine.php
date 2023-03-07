<?php
	include '../../../../private/initialize.php';

	$medicine = new Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['medicines'] as $medicines) {
		if($data['supplier_medicine_id'] == $medicines['supplier_medicine_id']) {
			$medicine->medicine_id = $medicines['medicine_id'];
			$medicine->supplier_medicine_id = $medicines['supplier_medicine_id'];
			$medicine->quantity = $medicines['quantity'] + $data['received_quantity'];
			$medicine->status = "Active";
			$medicine->barangay_id = $medicines['barangay_id'];

			$medicine->updateMedicine();
		}
	}