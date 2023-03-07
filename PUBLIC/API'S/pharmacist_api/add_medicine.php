<?php
	include '../../../private/initialize.php';

	$medicine = new Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	$medicine->supplier_medicine_id = $data['supplier_medicine_id'];
	$medicine->quantity = $data['quantity'];
	$medicine->status = $data['status'];
	$medicine->barangay_id = $data['barangay_id'];


	$medicine->addMedicine();