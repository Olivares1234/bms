<?php
	
	class Beneficiary {
		public $beneficiary_id;
		public $first_name;
		public $last_name;
		public $middle_name;
		public $contact_no;
		public $birth_date;
		public $email_address;
		public $sex;
		public $address;
		public $educational_attainment;
		public $occupation;
		public $religion;
		public $civil_status_id;
		public $status;
		public $beneficiary_type_id;
		public $balance;
		public $barangay_id;
		public $voters_id;
		public $is_dependent;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function beneficiaryToPriority() {
			$sql="UPDATE `tbl_beneficiary` SET `beneficiary_type_id` = :beneficiary_type_id WHERE `beneficiary_id` = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":beneficiary_type_id" => $this->beneficiary_type_id
			]);
		}

		public function transferBarangay() {
			$sql="UPDATE `tbl_beneficiary` SET `barangay_id` = :barangay_id WHERE `beneficiary_id` = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":barangay_id" => $this->barangay_id
			]);
		}

		public function beneficiaryIsDependent() {
			$sql="UPDATE `tbl_beneficiary` SET `is_dependent` = '1' WHERE `tbl_beneficiary`.`voters_id` = :voters_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":voters_id" => $this->voters_id
			]);
		}

		public function updateBeneficiaryIsDependent() {
			$sql="UPDATE `tbl_beneficiary` SET `is_dependent` = '0' WHERE `tbl_beneficiary`.`beneficiary_id` = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id
			]);
		}

		public function deactivateBeneficiary() {
			$sql="UPDATE `tbl_beneficiary` SET `status` = :status WHERE `tbl_beneficiary`.`beneficiary_id` = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":status" => $this->status
			]);
		}

		public function activateBeneficiary() {
			$sql = "UPDATE `tbl_beneficiary` SET `status` = :status, `beneficiary_type_id` = :beneficiary_type_id WHERE `tbl_beneficiary`.`beneficiary_id` = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":status" => $this->status,
				":beneficiary_type_id" => $this->beneficiary_type_id
			]);
		}

		public function searchBeneficiaryUsingId($barangay_id, $beneficiary_id) {
			$sql="SELECT * FROM tbl_beneficiary WHERE barangay_id = :barangay_id AND beneficiary_id LIKE :beneficiary_id
				ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":beneficiary_id" => '%' . $beneficiary_id . '%'
			]);

			return $stmt->fetchAll();
		}

		public function updateBeneficiaryBalance() {
			$sql = "UPDATE `tbl_beneficiary` SET `balance` = :balance WHERE `tbl_beneficiary`.`beneficiary_id` = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":balance" => $this->balance
			]);
		}

		public function retrieveAllBeneficiary($beneficiary_type_id) {
			$sql="SELECT * FROM tbl_beneficiary WHERE beneficiary_type_id != :beneficiary_type_id ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_type_id" => $beneficiary_type_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveBeneficiary($barangay_id) {
			$sql="SELECT * FROM tbl_beneficiary WHERE barangay_id = :barangay_id ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();

		}

		public function retrieveOverAllInactiveBeneficiary() {
			$sql="SELECT * FROM tbl_beneficiary WHERE status = 'Not Active' AND is_dependent = 0 ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveOverAllActiveBeneficiaryFromDependent() {
			$sql="SELECT * FROM tbl_beneficiary WHERE status = 'Active' AND (beneficiary_type_id != '2' AND beneficiary_type_id != '3' AND beneficiary_type_id != '5') ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveOverAllActiveBeneficiary() {
			$sql="SELECT * FROM tbl_beneficiary WHERE status = 'Active' ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function searchOverAllActiveBeneficiary($beneficiary_id) {
			$sql="SELECT * FROM tbl_beneficiary WHERE status = 'Active' AND beneficiary_id LIKE :beneficiary_id  ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => "%" . $beneficiary_id . "%"
			]);

			return $stmt->fetchAll();
		}
		public function retrieveOverAllBeneficiary() {
			$sql="SELECT * FROM tbl_beneficiary ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addBeneficiary() {
			$sql="INSERT INTO `tbl_beneficiary`(`beneficiary_id`, `first_name`, `last_name`, `middle_name`, `contact_no`, `birth_date`, `email_address`, `sex`, `address`, `educational_attainment`, `occupation`, `religion`, `civil_status_id`, `status`, `beneficiary_type_id`, `balance`, `barangay_id`, `voters_id`, `is_dependent`) VALUES (:beneficiary_id, :first_name, :last_name, :middle_name, :contact_no, :birth_date, :email_address, :sex, :address, :educational_attainment, :occupation, :religion, :civil_status_id, :status, :beneficiary_type_id, :balance, :barangay_id, :voters_id, :is_dependent)";



			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":first_name" => $this->first_name,
				":last_name" => $this->last_name,
				":middle_name" => $this->middle_name,
				":contact_no" => $this->contact_no,
				":birth_date" => $this->birth_date,
				":email_address" => $this->email_address,
				":sex" => $this->sex,
				":address" => $this->address,
				":educational_attainment" => $this->educational_attainment,
				":occupation" => $this->occupation,
				":religion" => $this->religion,
				":civil_status_id" => $this->civil_status_id,
				":status" => $this->status,
				":beneficiary_type_id" => $this->beneficiary_type_id,
				":balance" => $this->balance,
				":barangay_id" => $this->barangay_id,
				":voters_id" => $this->voters_id,
				":is_dependent" => $this->is_dependent
			]);
		}
		public function updateBeneficiary() {
			$sql = "UPDATE `tbl_beneficiary` SET `beneficiary_id`= :beneficiary_id,`first_name`=:first_name,`last_name`= :last_name,`middle_name`= :middle_name,`contact_no`= :contact_no,`birth_date`= :birth_date,`email_address`= :email_address,`sex`= :sex,`address`= :address, `educational_attainment` = :educational_attainment, `occupation` = :occupation, `religion` = :religion, `civil_status_id` = :civil_status_id, `barangay_id`= :barangay_id, `beneficiary_type_id` = :beneficiary_type_id, `voters_id` = :voters_id WHERE beneficiary_id = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":first_name" => $this->first_name,
				":last_name" => $this->last_name,
				":middle_name" => $this->middle_name,
				":contact_no" => $this->contact_no,
				":birth_date" => $this->birth_date,
				":email_address" => $this->email_address,
				":sex" => $this->sex,
				":address" => $this->address,
				":educational_attainment" => $this->educational_attainment,
				":occupation" => $this->occupation,
				":religion" => $this->religion,
				":civil_status_id" => $this->civil_status_id,
				":barangay_id" => $this->barangay_id,
				":beneficiary_type_id" => $this->beneficiary_type_id,
				":voters_id" => $this->voters_id
			]);
		}

		public function getGender() {
			$sql="SELECT sex AS Sex, COUNT(Sex) AS Total FROM tbl_beneficiary GROUP BY sex ORDER BY Sex DESC";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getAge() {
			$sql="SELECT Bracket.lbl AS Bracket, COUNT(birth_date) AS Total
					FROM (
					    SELECT 18 AS a, 24 AS b, '18-24' AS lbl UNION ALL
					    SELECT 25,      34,      '25-34'        UNION ALL
					    SELECT 35,      44,      '35-44'        UNION ALL
					    SELECT 45,      54,     '45-54' UNION ALL
					    SELECT 55,      64,     '55-64' UNION ALL
					    SELECT 65,      999,     '65-99+'
					) AS Bracket
					LEFT JOIN tbl_beneficiary ON YEAR(CURRENT_DATE) - YEAR(birth_date) BETWEEN a and b
					GROUP BY Bracket.lbl";

				$stmt = $this->connection->prepare($sql);

				$stmt->execute();

				return $stmt->fetchAll();
		}

		public function getAddedBeneficiary() {
			$sql="SELECT DATE_FORMAT(tbl_date.date, '%b') AS Month, MONTH(tbl_date.date) as month_num, COUNT(tbl_activate_beneficiary_details.beneficiary_id) AS Total FROM tbl_date LEFT JOIN tbl_activate_beneficiary_details ON tbl_activate_beneficiary_details.date_activated = tbl_date.date WHERE YEAR(tbl_date.date) = YEAR(NOW()) GROUP BY Month, month_num ORDER BY month_num";
			
			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieve4psBeneficiary() {
			$sql="SELECT * FROM `tbl_beneficiary` WHERE beneficiary_type_id = '1' ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveBeneficiaryType() {
			$sql="SELECT * FROM tbl_beneficiary_type WHERE 1";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrievePwdBeneficiary() {
			$sql="SELECT * FROM `tbl_beneficiary` WHERE beneficiary_type_id = '2' ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveSeniorBeneficiary() {
			$sql="SELECT * FROM `tbl_beneficiary` WHERE beneficiary_type_id = '3' ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveIndigentBeneficiary() {
			$sql="SELECT * FROM `tbl_beneficiary` WHERE beneficiary_type_id = '4' ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function searchBeneficiary($filter, $keyword, $barangay_id) {
			$sql="SELECT * FROM tbl_beneficiary WHERE barangay_id = :barangay_id AND CASE
					WHEN :filter = 'id' THEN (beneficiary_id LIKE :keyword)
					WHEN :filter = 'name' THEN (first_name LIKE :keyword OR middle_name LIKE :keyword OR last_name LIKE :keyword)
					WHEN :filter = 'status' THEN (status LIKE :keyword)
				END
				ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function searchRegistrationBeneficiary($filter, $keyword) {
			$sql="SELECT * FROM tbl_beneficiary WHERE 
				CASE
					WHEN :filter = 'status' THEN status LIKE :keyword
				END";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}

	}