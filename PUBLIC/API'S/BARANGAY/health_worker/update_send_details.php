<?php

	include '../../../../private/initialize.php';

	$send_details = new Send_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	$send_details->send_details_id = $data['send_details_id'];

	$send_details->received_quantity = $data['received_quantity'] + $data['previos_received_quantity'];

	$send_details->updateSendDetails();

	


