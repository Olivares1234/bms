<?php

	include '../../../../private/initialize.php';

	$transaction = new Transaction();
	
	echo json_encode($transaction->searchTransaction($_GET['transaction_id'], $_SESSION['barangay_id']));