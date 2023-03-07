<?php
	include '../../../../private/initialize.php';

	$purchase_received_details = new Purchase_Received_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$purchase_received_details->purchase_received_id = $_SESSION['purchase_received_id'];
	$purchase_received_details->supplier_medicine_id = $data['supplier_medicine_id'];
	$purchase_received_details->received_quantity = $data['received_quantity'];
	$purchase_received_details->expiration_date = $data['expiration_date'];
	$purchase_received_details->status = $data['status'];
	$purchase_received_details->barcode = $data['barcode'];

	$purchase_received_details->addPurchaseReceivedDetails();