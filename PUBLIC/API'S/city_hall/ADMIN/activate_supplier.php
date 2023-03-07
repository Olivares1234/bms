<?php
	include '../../../../private/initialize.php';

	$supplier = new Supplier();

	$data = json_decode(file_get_contents("php://input"),true);

	$supplier->activateSupplier($data['supplier_id']);
	
		
	

