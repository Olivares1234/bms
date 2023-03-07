<?php

	include '../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();

	$received_order_details->send_order_id = $_GET['send_order_id'];
	$received_order_details->supplier_medicine_id = $_GET['supplier_medicine_id'];


	echo json_encode($received_order_details->retrieveGulodReceivedOrderDetails());