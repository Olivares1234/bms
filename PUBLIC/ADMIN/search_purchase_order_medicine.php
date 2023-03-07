<?php

	include '../../private/initialize.php';

	$purchase_order_details = new Purchase_Order_Details();
	

	$purchase_order_details->purchase_order_id = $_GET['']
	echo json_encode($purchase_order_details->getPurchaseOrderDetails($_GET['purchase_order_id']));