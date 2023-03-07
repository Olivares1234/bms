<?php

	include '../../../../private/initialize.php';

	$beneficiary = new Beneficiary();
	
	echo json_encode($beneficiary->searchBeneficiary($_GET['filter'], $_GET['keyword'], $_SESSION['barangay_id']));