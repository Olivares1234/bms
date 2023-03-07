<?php

	include '../../../../private/initialize.php';

	$medicine = new Medicine();

	echo json_encode($medicine->retrieveMedicine($_SESSION['barangay_id']));