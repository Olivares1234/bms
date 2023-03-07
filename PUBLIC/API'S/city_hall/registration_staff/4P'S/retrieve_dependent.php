<?php

	include '../../../../../private/initialize.php';

	$dependent = new Dependent();

	echo json_encode($dependent->retrieveDependent($_GET['beneficiary_id']));