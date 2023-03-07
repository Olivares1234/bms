<?php

	include '../../../private/initialize.php';

	$return_medicine_details = new Return_Medicine_Details();

	echo json_encode($return_medicine_details->retrieveReturnMedicineDetails($_GET['transaction_id']));