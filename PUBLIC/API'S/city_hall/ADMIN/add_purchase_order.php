<?php
	include '../../../../private/initialize.php';

	$purchase_order = new Purchase_Order();

	$data = json_decode(file_get_contents("php://input"),true);

	$purchase_order->purchase_order_id = $data['purchase_order_id'];
	$purchase_order->user_id = $_SESSION['user_id'];
	$purchase_order->date_ordered = $data['date_ordered'];

	$_SESSION['purchase_order_id'] = $purchase_order->purchase_order_id;

	$purchase_order->addPurchaseOrder();