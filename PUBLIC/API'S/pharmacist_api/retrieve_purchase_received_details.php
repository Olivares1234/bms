<?php

	include '../../../private/initialize.php';

	$purchase_received_details = new Purchase_Received_Details();
	
	$purchase_received_details->purchase_order_id = $_GET['purchase_order_id'];
	$purchase_received_details->supplier_medicine_id = $_GET['supplier_medicine_id'];
	
	echo json_encode($purchase_received_details->retrievePurchaseReceivedDetails());