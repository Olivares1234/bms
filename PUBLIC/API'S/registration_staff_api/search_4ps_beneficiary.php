<?php

	include '../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	echo json_encode($beneficiary->search4psBeneficiary($_GET['keyword']));