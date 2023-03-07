<?php
	include '../../../../private/initialize.php';

	$request_order = new Request_Order();

	$data = json_decode(file_get_contents("php://input"),true);

	$request_order->request_order_id = $data['request_order_id'];
	$request_order->user_id = $_SESSION['user_id'];
	$request_order->date_request = $data['date_request'];
	$request_order->barangay_id = $_SESSION['barangay_id'];
	$request_order->request_order_status = $data['request_order_status'];


	$_SESSION['request_order_id'] = $request_order->request_order_id;

	$request_order->addRequestOrder();