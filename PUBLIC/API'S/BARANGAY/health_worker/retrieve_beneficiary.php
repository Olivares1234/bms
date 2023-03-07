<?php

	include '../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	echo json_encode($beneficiary->retrieveBeneficiary($_SESSION['barangay_id']));