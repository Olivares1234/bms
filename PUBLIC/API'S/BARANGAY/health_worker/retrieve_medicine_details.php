<?php

	include '../../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();

	echo json_encode($received_order_details->medicineDetails($_GET['supplier_medicine_id'], $_SESSION['barangay_id']));