<?php 
	include '../../../../private/initialize.php';

	$request_details = new Request_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['request_details'] as $request_detail) {

		$request_details->request_details_id = $request_detail['request_details_id'];
		$request_details->purchase_received_details_id = $request_detail['purchase_received_details_id'];
		$request_details->delivered_quantity = $request_detail['delivered_quantity'];


		$request_details->updateRequestDetails();
	}

	