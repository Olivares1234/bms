a<?php
	include '../../../private/initialize.php';

	$transaction_detail = new Transaction_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['gulod_transactions'] as $gulod_transaction) {
		$transaction_detail->transaction_id = $_SESSION['transaction_id'];
		$transaction_detail->quantity = $gulod_transaction['quantity'];
		$transaction_detail->supplier_medicine_id = $gulod_transaction['id'];
		$transaction_detail->price = $gulod_transaction['price'];
		$transaction_detail->total_price = $gulod_transaction['total'];

		$transaction_detail->addTransactionDetails();

	}