<?php

	include '../../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	echo json_encode($beneficiary->retrieveAllBeneficiary($_GET['beneficiary_type_id']));