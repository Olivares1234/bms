<?php

	include '../../../../private/initialize.php';

	$referral_details = new Return_Medicine_Details();
	
	echo json_encode($referral_details->searchReturnedMedicine($_GET['filter'], $_GET['keyword']));