a<?php
	include '../../../../private/initialize.php';

	$transaction_detail = new Transaction_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['transactions'] as $transaction) {
		$transaction_detail->transaction_id = $_SESSION['transaction_id'];
		$transaction_detail->quantity = $transaction['quantity'];
		$transaction_detail->received_order_details_id = $transaction['id'];
		$transaction_detail->price = $transaction['price'];
		$transaction_detail->total_price = $transaction['total'];

		$transaction_detail->addTransactionDetails();
	} 