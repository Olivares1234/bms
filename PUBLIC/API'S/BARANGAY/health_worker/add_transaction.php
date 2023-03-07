<?php
	include '../../../../private/initialize.php';

	$transaction = new Transaction();

	$data = json_decode(file_get_contents("php://input"),true);


	$transaction->transaction_id = $data['transaction_id'];
	$transaction->beneficiary_id = $data['beneficiary_id'];
	$transaction->user_id = $_SESSION['user_id'];
	$transaction->transaction_date = $data['transaction_date'];
	$transaction->barangay_id = $_SESSION['barangay_id'];

	$_SESSION['transaction_id'] = $transaction->transaction_id;

	$transaction->addTransaction();