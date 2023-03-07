<?php

	include '../../../private/initialize.php';

	$purchase_details = new Purchase_Details();
	
	echo json_encode($purchase_details->retrievePurchaseDetails($_GET['purchase_order_id']));