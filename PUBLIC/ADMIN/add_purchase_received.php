<?php
	include '../../private/initialize.php';

	$purchase_received = new Purchase_Received();

	$data = json_decode(file_get_contents("php://input"),true);

	$purchase_received->purchase_received_id = $data['purchase_received_id'];
	$purchase_received->user_id = $_SESSION['user_id'];
	$purchase_received->date_received = $data['date_received'];
	$purchase_received->purchase_order_id = $data['purchase_order_id'];

	$_SESSION['purchase_received_id'] = $purchase_received->purchase_received_id;

	$purchase_received->addPurchaseReceived();