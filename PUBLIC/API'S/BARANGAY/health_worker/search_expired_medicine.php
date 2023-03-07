<?php

	include '../../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();
	
	echo json_encode($received_order_details->searchExpiredMedicine($_SESSION['barangay_id'], $_GET['keyword'], $_GET['filter']));