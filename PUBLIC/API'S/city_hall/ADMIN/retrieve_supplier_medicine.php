<?php

	include '../../../../private/initialize.php';

	$supplier_medicine = new Supplier_Medicine();

	echo json_encode($supplier_medicine->getAllSupplierMedicine($_GET['supplier_id']));