<?php
	include '../../../private/initialize.php';

	$request_order = new Request_Order();

	$data = json_decode(file_get_contents("php://input"),true);

	$request_order->request_order_id = $data['request_order_id'];
	$request_order->request_order_status = "Completed";

	$request_order->updateRequestOrder();

	