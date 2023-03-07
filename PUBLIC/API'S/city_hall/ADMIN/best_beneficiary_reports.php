<?php

	include '../../../../private/initialize.php';

	$transaction_details = new Transaction_Details();

	echo json_encode($transaction_details->getBestBeneficiaryPerBarangay($_GET['barangay_id'], $_GET['search']));