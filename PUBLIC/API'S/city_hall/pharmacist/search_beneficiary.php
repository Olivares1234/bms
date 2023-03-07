<?php

	include '../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	echo json_encode($beneficiary->searchBeneficiaryUsingId($_GET['barangay_id'], $_GET['beneficiary_id']));