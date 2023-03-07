<?php

	include '../../../private/initialize.php';

	$barangay = new Barangay();

	echo json_encode($barangay->getInventory($_GET['barangay_id']));