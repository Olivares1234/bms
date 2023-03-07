<?php
	include '../../../../private/initialize.php';

	$send_order = new Send_Order();

	$data = json_decode(file_get_contents("php://input"),true);

	$send_order->send_order_id = $data['send_order_id'];
	$send_order->user_id = $_SESSION['user_id'];
	$send_order->date_send = $data['date_send'];
	$send_order->request_order_id = $data['request_order_id'];
	$send_order->barangay_id = $data['barangay_id'];

	$_SESSION['send_order_id'] = $send_order->send_order_id;

	$send_order->addSendOrder();