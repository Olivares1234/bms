<?php

	include '../../../../private/initialize.php';

	$purchase_received = new Purchase_Received_Details();

	echo json_encode($purchase_received->getPurchaseReceivedReports($_GET['search']));