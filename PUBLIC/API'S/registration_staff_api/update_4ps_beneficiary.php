 <?php
	include '../../../private/initialize.php';
 
	$beneficiary = new Beneficiary();

	$data = json_decode(file_get_contents("php://input"),true);

	$beneficiary->beneficiary_id = $data['beneficiary_id'];
	$beneficiary->first_name = $data['first_name'];
	$beneficiary->last_name = $data['last_name'];
	$beneficiary->middle_name = $data['middle_name'];
	$beneficiary->contact_no = $data['contact_no'];
	$beneficiary->birth_date = $data['birth_date'];
	$beneficiary->email_address = $data['email_address'];
	$beneficiary->sex = $data['sex'];
	$beneficiary->address = $data['address'];
	$beneficiary->educational_attainment = $data['educational_attainment'];
	$beneficiary->occupation = $data['occupation'];
	$beneficiary->religion = $data['religion'];
	$beneficiary->civil_status_id = $data['civil_status_id'];
	$beneficiary->status = $data['status'];
	$beneficiary->beneficiary_type_id = $data['beneficiary_type_id'];
	$beneficiary->balance = $data['balance'];
	$beneficiary->barangay_id = $data['barangay_id'];


	$beneficiary->updateBeneficiary();

	