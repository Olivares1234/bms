<?php
	include '../../../../private/initialize.php';

	$return_referral_medicine_details = new Return_Referral_Medicine_Details();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['referral_details'] as $referral_details) {
		if($referral_details['referral_transaction_details_id'] == $data['referral_transaction_details_id']) {

			$return_referral_medicine_details->return_referral_medicine_id = $_SESSION['return_referral_medicine_id'];

			$return_referral_medicine_details->purchase_received_details_id = $referral_details['purchase_received_details_id'];

			$return_referral_medicine_details->quantity =  $data['quantity'];

			$return_referral_medicine_details->total_amount = $return_referral_medicine_details->quantity * $referral_details['price'];

			$return_referral_medicine_details->remarks = $data['remarks'];
			

			$return_referral_medicine_details->addReturnReferralMedicineDetails();
		}
	}

	