<?php
	include '../../../private/initialize.php';
	
	$beneficiary = new Beneficiary();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['gulod_transaction_details'] as $gulod_transaction_detail) {
		foreach ($data['beneficiaries'] as $beneficiaries) {
			if($gulod_transaction_detail['beneficiary_id'] == $beneficiaries['beneficiary_id']) {
				if($gulod_transaction_detail['supplier_medicine_id'] == $data['supplier_medicine_id']) {

					$beneficiary->beneficiary_id = $beneficiaries['beneficiary_id'];

					$beneficiary->first_name = $beneficiaries['first_name'];

					$beneficiary->last_name = $beneficiaries['last_name'];

					$beneficiary->middle_name = $beneficiaries['middle_name'];

					$beneficiary->contact_no = $beneficiaries['contact_no'];

					$beneficiary->birth_date = $beneficiaries['birth_date'];

					$beneficiary->email_address = $beneficiaries['email_address'];

					$beneficiary->sex = $beneficiaries['sex'];

					$beneficiary->address = $beneficiaries['address'];

					$beneficiary->educational_attainment = $beneficiaries['educational_attainment'];

					$beneficiary->occupation = $beneficiaries['occupation'];

					$beneficiary->religion = $beneficiaries['religion'];

					$beneficiary->civil_status_id = $beneficiaries['civil_status_id'];

					$beneficiary->status = $beneficiaries['status'];

					$beneficiary->balance = $beneficiaries['balance'] - ($gulod_transaction_detail['price'] * $data['quantity']);

					$beneficiary->beneficiary_type_id = $beneficiaries['beneficiary_type_id'];
					$beneficiary->barangay_id = $beneficiaries['barangay_id'];

					$beneficiary->updateBeneficiary();
				}
			}
			
		}
	}

	
	
	