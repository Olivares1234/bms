<?php

	include '../../../../private/initialize.php';

	$send_details = new Send_Details();

	echo json_encode($send_details->searchSendDetails($_SESSION['barangay_id'], $_GET['keyword'], $_GET['filter'], $_GET['send_order_id']));