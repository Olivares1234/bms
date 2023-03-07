<?php
	include '../../../private/initialize.php';

	$unit_category = new Unit_Category();

	$data = json_decode(file_get_contents("php://input"),true);

	$response = [];
	$response['status'] = "OK";

	if(empty($data['unit'])) {
		$response['unit_category_unit_error'] = true;
		$response['status'] = "NOT_OK";
	}
	
	if($response['status'] == "NOT_OK") {
		echo json_encode($response);
	} else {
		$unit_category = new Unit_Category();

		$response['status'] = "OK";

		echo json_encode($response);

		$unit_category->unit = $data['unit'];

		$unit_category->addUnitCategory();
	}