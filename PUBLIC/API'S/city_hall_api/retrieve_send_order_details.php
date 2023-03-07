<?php

	include '../../../private/initialize.php';

	$send_order_details = new Send_Order_Details();

	echo json_encode($send_order_details->retrieveSendOrderDetails($_GET['request_order_id']));