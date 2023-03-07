<?php

	include '../../../../private/initialize.php';

	$purchase_received_details = new Purchase_Received_Details();

	echo json_encode($purchase_received_details->retrievePurchaseReceivedDetails($_GET['purchase_order_id'], $_GET['supplier_medicine_id']));