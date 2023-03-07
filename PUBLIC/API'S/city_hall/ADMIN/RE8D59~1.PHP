<?php

	include '../../../../private/initialize.php';

	$purchase_details = new Purchase_Order_Details();

	echo json_encode($purchase_details->getPurchaseOrdersReports($_GET['search']));