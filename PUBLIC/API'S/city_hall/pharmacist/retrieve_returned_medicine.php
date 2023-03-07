<?php

	include '../../../../private/initialize.php';

	$return_referral_medicine_details = new Return_Referral_Medicine_Details();

	echo json_encode($return_referral_medicine_details->retrieveReturnedMedicine());