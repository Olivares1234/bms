<?php

	include '../../../private/initialize.php';

	$supplier = new Supplier();

	echo json_encode($supplier->getAllSupplier());