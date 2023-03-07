<?php

	include '../../../../../private/initialize.php';

	$dependent = new Dependent();

	echo json_encode($dependent->retrieveBeneficiaryDependent($_GET['beneficiary_id']));