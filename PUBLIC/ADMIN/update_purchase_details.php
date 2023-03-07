<?php
	include '../../private/initialize.php';

	$purchase_details = new Purchase_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$purchase_details->purchase_details_id = $data['purchase_details_id'];
	$purchase_details->purchase_order_id = $data['purchase_order_id'];
	$purchase_details->supplier_medicine_id = $data['supplier_medicine_id'];
	$purchase_details->quantity = $data['quantity'];
	$purchase_details->received_quantity = $data['received_quantity'];

	$purchase_details->updatePurchaseDetails();