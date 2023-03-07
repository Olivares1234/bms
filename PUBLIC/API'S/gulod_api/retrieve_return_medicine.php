<?php

	include '../../../private/initialize.php';

	$return_medicine = new Return_Medicine();

	echo json_encode($return_medicine->retrieveReturnMedicine());