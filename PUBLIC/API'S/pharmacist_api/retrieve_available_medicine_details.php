<?php

	include '../../../private/initialize.php';

	$medicine = new Medicine();

	echo json_encode($medicine->viewAllMedicineInformation($_GET['medicine_id']));