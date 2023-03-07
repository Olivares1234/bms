<?php
	include '../../../../../private/initialize.php';

	$dependent = new Dependent();

	$data = json_decode(file_get_contents("php://input"),true);


	$dependent->dependent_id = $data['dependent_id'];
	$dependent->status = "Active";

	$dependent->activateDependent();

	

	