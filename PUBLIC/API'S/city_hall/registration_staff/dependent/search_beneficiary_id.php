<?php

	include '../../../../../private/initialize.php';

	$beneficiary = new Beneficiary();

	echo json_encode($beneficiary->searchOverAllActiveBeneficiary($_GET['beneficiary_id']));