<?php

	include '../../../../private/initialize.php';

	$medicine = new Medicine();

	echo json_encode($medicine->retrieveUnavailableMedicine($_SESSION['barangay_id']));