<?php

	include '../../../private/initialize.php';

	$request_order_details = new Request_Order_Details();
	
	echo json_encode($request_order_details->retrieveBarangayRequestOrderDetails($_GET['request_order_id']));