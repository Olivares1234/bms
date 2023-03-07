<?php
	include '../../../../private/initialize.php';

	$supplier = new Supplier();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['supplier_name'])) {
		$response['supplier_name_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['supplier_address'])) {
		$response['supplier_address_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['supplier_contact_no'])) {
		$response['supplier_contact_no_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['supplier_status'])) {
		$response['supplier_status_error'] = true;
		$response['status'] = "NOT_OK";
	} else {
		$supplier = new Supplier();
		
		$response['status'] = "OK";

		echo json_encode($response);
		$supplier->supplier_name = $data['supplier_name'];
		$supplier->supplier_address = $data['supplier_address'];
		$supplier->supplier_contact_no = $data['supplier_contact_no'];
		$supplier->supplier_status = $data['supplier_status'];

		$supplier->addSupplier();
	}