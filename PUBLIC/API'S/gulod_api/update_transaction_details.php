<?php
	include '../../../private/initialize.php';

	$transaction_detail = new Transaction_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['transaction_details'] as $transaction_details) {
		if($transaction_details['transaction_id'] == $data['transaction_id']) {
			if($transaction_details['supplier_medicine_id'] == $data['supplier_medicine_id']) {

				$transaction_detail->details_id =  $transaction_details['details_id'];

				$transaction_detail->transaction_id = $data['transaction_id'];

				$transaction_detail->supplier_medicine_id = $data['supplier_medicine_id'];

				$transaction_detail->quantity = $transaction_details['quantity'] - $data['quantity'];

				$transaction_detail->price = $transaction_details['price'];
				
				$transaction_detail->total_price = $transaction_details['price'] * $transaction_detail->quantity;


				$transaction_detail->updateTransactionDetails();
			}
		}
	}