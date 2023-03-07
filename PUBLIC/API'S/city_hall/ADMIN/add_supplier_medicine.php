<?php
	include '../../../../private/initialize.php';

	$supplier_medicine = new Supplier_Medicine();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['medicine_name'])) {
		$response['supplier_medicine_name_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['category_id'])) {
		$response['supplier_medicine_category_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['unit_category_id'])) {
		$response['supplier_medicine_unit_category_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['price'])) {
		$response['supplier_medicine_price_error'] = true;
		$response['status'] = "NOT_OK";
	} else {
		$supplier_medicine = new Supplier_Medicine();
		
		$response['status'] = "OK";

		echo json_encode($response);
		
		$supplier_medicine->medicine_name = $data['medicine_name'];
		$supplier_medicine->category_id = $data['category_id'];
		$supplier_medicine->unit_category_id = $data['unit_category_id'];
		$supplier_medicine->price = $data['price'];
		$supplier_medicine->supplier_id = $data['supplier_id'];

		$supplier_medicine->addSupplierMedicine();
	}