<?php
	include '../../../../private/initialize.php';

	$purchase_order_details = new Purchase_Order_Details();

	$data = json_decode(file_get_contents("php://input"),true);


	foreach ($data['purchase_order_to_carts'] as $purchase_order_to_cart) {
		$purchase_order_details->purchase_order_id = $_SESSION['purchase_order_id'];
		$purchase_order_details->supplier_medicine_id = $purchase_order_to_cart['medicine_id'];
		$purchase_order_details->quantity =  $purchase_order_to_cart['quantity'];


		$purchase_order_details->addPurchaseOrderDetails();
	}