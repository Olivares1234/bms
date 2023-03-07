<?php

	include '../../../../private/initialize.php';

	$send_details = new Send_Details();

	echo json_encode($send_details->retrieveSendDetails($_GET['send_order_id']));