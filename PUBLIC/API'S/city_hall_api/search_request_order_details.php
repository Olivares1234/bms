<?php

	include '../../../private/initialize.php';

	$request_order_details = new Request_Order_Details();
	
	echo json_encode($request_order_details->searchRequestOrderDetails($_GET['keyword']));