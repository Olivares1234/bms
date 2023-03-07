<?php
	include '../../../../../private/initialize.php';

	$dependent = new Dependent();

	$data = json_decode(file_get_contents("php://input"),true);

	foreach ($data['addDependents'] as $addDependent) {

		$dependent->first_name = $addDependent['first_name'];
		$dependent->last_name = $addDependent['last_name'];
		$dependent->middle_name = $addDependent['middle_name'];
		$dependent->contact_no = $addDependent['contact_no'];
		$dependent->birth_date = $addDependent['birth_year'] . '-' . $addDependent['birth_month'] . '-' . $addDependent['birth_day'];
		$dependent->email_address = $addDependent['email_address'] . $addDependent['email_extension'];
		$dependent->sex = $addDependent['sex'];
		$dependent->address = $addDependent['house_no'] . ',' . $addDependent['street'] . ',' . $addDependent['subdivision'];
		$dependent->educational_attainment = $addDependent['educational_attainment'];
		$dependent->occupation = $addDependent['occupation'];
		$dependent->religion = $addDependent['religion'];
		if($addDependent['civil_status'] == "Single") {
			$dependent->civil_status_id = 1;
		}
		else if($addDependent['civil_status'] == "Married") {
			$dependent->civil_status_id = 2;
		}
		else {
			$dependent->civil_status_id = 3;
		}
		
		$dependent->status = "Active";
		$dependent->barangay_id = $data['barangay_id'];
		$dependent->beneficiary_id = $_SESSION['beneficiary_id'];

		$dependent->addDependent();	
	}

	