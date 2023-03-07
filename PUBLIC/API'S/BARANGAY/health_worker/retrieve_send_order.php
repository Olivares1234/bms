<?php

	include '../../../../private/initialize.php';

	$send_order = new Send_Order();

	echo json_encode($send_order->getSendOrder($_SESSION['barangay_id']));