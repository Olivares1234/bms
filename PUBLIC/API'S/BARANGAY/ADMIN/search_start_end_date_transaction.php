<?php

	include '../../../../private/initialize.php';

	$transaction_details = new Transaction_Details();
	
	echo json_encode($transaction_details->getAllBarangayStartEndDate($_GET['start_date'], $_GET['end_date']));