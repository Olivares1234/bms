<?php
	include '../../private/initialize.php';

	$purchase_order_details = new Purchase_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$purchase_order_details->purchase_order_details_id = $data['purchase_order_details_id'];
	$purchase_order_details->purchase_order_id = $data['purchase_order_id'];
	$purchase_order_details->supplier_medicine_id = $data['supplier_medicine_id'];
	$purchase_order_details->quantity = $data['quantity'];
	$purchase_order_details->supplier_id = $data['supplier_id'];

	$purchase_order_details->updatePurchaseOrderDetails();