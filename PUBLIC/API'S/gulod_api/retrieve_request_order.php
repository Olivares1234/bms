<?php

	include '../../../private/initialize.php';

	$request_order = new Request_Order();

	echo json_encode($request_order->retrieveRequestOrder());