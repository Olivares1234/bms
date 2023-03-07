<?php

	include '../../../../private/initialize.php';

	$supplier = new Supplier();
	
	echo json_encode($supplier->searchSupplier($_GET['filter'], $_GET['keyword']));