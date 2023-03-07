<?php

	include '../../../private/initialize.php';

	$purchase_details = new Purchase_Details();
	

	$purchase_details->purchase_order_id = $_GET['purchase_order_id'];
	$purchase_details->search_purchase_details = $_GET['search_purchase_details'];

	echo json_encode($purchase_details->searchPurchaseDetails());