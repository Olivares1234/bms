<?php

	include '../../../private/initialize.php';

	$received_order = new Received_Order();

	echo json_encode($received_order->getAllGulodReceivedOrder());