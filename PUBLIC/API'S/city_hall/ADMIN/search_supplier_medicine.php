<?php

	include '../../../../private/initialize.php';

	$supplier_medicine = new Supplier_Medicine();
	
	echo json_encode($supplier_medicine->searchSupplierMedicine($_GET['supplier_id'], $_GET['keyword']));