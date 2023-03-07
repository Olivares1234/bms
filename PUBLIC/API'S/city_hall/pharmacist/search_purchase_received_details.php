<?php

	include '../../../../private/initialize.php';

	$purchase_details = new Purchase_Details();
	
	echo json_encode($purchase_details->searchPurchaseReceivedDetails($_GET['purchase_order_id'], $_GET['filter'], $_GET['keyword']));