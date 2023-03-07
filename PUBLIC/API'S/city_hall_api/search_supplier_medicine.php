<?php

	include '../../../private/initialize.php';

	$supplier_medicine = new Supplier_Medicine();
	
	$supplier_medicine->supplier_id = $_GET['supplier_id'];
	$supplier_medicine->keyword = $_GET['keyword'];

	echo json_encode($supplier_medicine->searchSupplierMedicine());