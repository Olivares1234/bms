<?php
	include '../../../private/initialize.php';
	
	$category = new Category();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['category_id'])) {
		$response['category_id_error'] = true;
		$response['status'] = "NOT_OK";
	}

	if(empty($data['description'])) {
		$response['supplier_name_error'] = true;
		$response['status'] = "NOT_OK";
	}
	
	if($response['status'] == "NOT_OK") {
		echo json_encode($response);
	} else {
		$category = new Category();

		$response['status'] = "OK";

		echo json_encode($response);

		$category->category_id = $data['category_id'];
		$category->description = $data['description'];
		
		$category->updateCategory();
	}