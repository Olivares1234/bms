<?php

	include '../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	echo json_encode($beneficiary->retrieveBeneficiary($_GET['barangay_id']));