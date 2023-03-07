<?php

	include '../../private/initialize.php';

	$medicine = new Medicine();

	echo json_encode($medicine->viewAllCityHallMedicine($_GET['medicine_id']));