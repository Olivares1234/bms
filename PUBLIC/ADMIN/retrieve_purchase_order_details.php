<?php

	include '../../private/initialize.php';

	$purchase_order_details = new Purchase_Order_Details();

	echo json_encode($purchase_order_details->retrieveAllPurchaseOrderDetails());