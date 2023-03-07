<?php

	include '../../../../../private/initialize.php';

	$beneficiary = new Beneficiary();
	
	echo json_encode($beneficiary->searchRegistrationBeneficiary($_GET['filter'], $_GET['keyword']));