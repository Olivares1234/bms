<?php

	include '../../../../private/initialize.php';

	$return_referral_medicine = new Return_Referral_Medicine();

	echo json_encode($return_referral_medicine->retrieveReturnMedicine());