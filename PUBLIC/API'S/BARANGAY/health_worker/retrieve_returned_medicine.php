<?php

	include '../../../../private/initialize.php';

	$return_medicine_details = new Return_Medicine_Details();

	echo json_encode($return_medicine_details->retrieveReturnedMedicine());