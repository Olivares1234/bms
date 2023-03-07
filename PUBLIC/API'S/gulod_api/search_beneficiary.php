<?php

	include '../../../private/initialize.php';

	$beneficiary = new Beneficiary();
	
	echo json_encode($beneficiary->searchGulodBeneficiary($_GET['keyword']));