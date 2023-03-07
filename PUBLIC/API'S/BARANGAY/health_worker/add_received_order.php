<?php
	include '../../../../private/initialize.php';

	$received_order = new Received_Order();

	$data = json_decode(file_get_contents("php://input"),true);

	$received_order->received_order_id = $data['received_order_id'];
	$received_order->send_order_id = $data['send_order_id'];
	$received_order->user_id = $_SESSION['user_id'];
	$received_order->date_received = $data['date_received'];
	$received_order->barangay_id = $_SESSION['barangay_id'];

	$_SESSION['received_order_id'] = $received_order->received_order_id;


	$received_order->addReceivedOrder();