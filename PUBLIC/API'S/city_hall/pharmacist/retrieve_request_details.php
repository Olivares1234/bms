<?php

	include '../../../../private/initialize.php';

	$request_details = new Request_Details();

	echo json_encode($request_details->retrieveRequestDetails($_GET['request_order_id']));