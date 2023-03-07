	<?php

	include '../../../../private/initialize.php';

	$received_order_details = new Received_Order_Details();

	echo json_encode($received_order_details->retrieveReceivedOrderDetails($_GET['send_order_id'], $_GET['purchase_received_details_id'], $_SESSION['barangay_id']));