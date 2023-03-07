<?php

	include '../../../../private/initialize.php';

	$barangay = new Received_Order_Details();

	echo json_encode($barangay->medicinePerBarangay($_GET['filter'], $_GET['barangay_id']));