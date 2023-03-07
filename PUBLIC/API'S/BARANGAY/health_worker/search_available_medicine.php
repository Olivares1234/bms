<?php

	include '../../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();

	echo json_encode($received_order_details->searchAvailableMedicine($_SESSION['barangay_id'], $_GET['keyword'], $_GET['filter']));