<?php

	include '../../../../private/initialize.php';

	$transaction = new Transaction();
	
	echo json_encode($transaction->retrieveTransaction($_SESSION['barangay_id']));