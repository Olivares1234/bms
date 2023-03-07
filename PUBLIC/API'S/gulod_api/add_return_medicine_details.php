<?php
	include '../../../private/initialize.php';

	$return_medicine_details = new Return_Medicine_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['price'])) {
		$response['return_medicine_quantity_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['remarks'])) {
		$response['return_medicine_remarks_error'] = true;
		$response['status'] = "NOT_OK";
	}
	else 
	{
		foreach ($data['supplier_medicines'] as $supplier_medicine) {
			if($supplier_medicine['supplier_medicine_id'] == $data['supplier_medicine_id']) {
				$return_medicine_details->return_medicine_id = $_SESSION['return_medicine_id'];
				$return_medicine_details->supplier_medicine_id = $data['supplier_medicine_id'];
				$return_medicine_details->quantity = $data['quantity'];
				$return_medicine_details->total_amount = $return_medicine_details->quantity * $supplier_medicine['price'];
				$return_medicine_details->remarks = $data['remarks'];

				$return_medicine_details->addReturnMedicineDetails();
			}
		}
	}

	