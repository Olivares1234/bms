<?php
	
	class Dependent {
		public $dependent_id;
		public $fullname;
		public $sex;
		public $educational_attainment;
		public $occupation;
		public $civil_status_id;
		public $status;
		public $voters_id;
		public $beneficiary_id;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveBeneficiaryDependent($beneficiary_id) {
			$sql="SELECT * FROM tbl_dependent WHERE beneficiary_id = :beneficiary_id ORDER BY dependent_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => $beneficiary_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveAllActiveDependent() {
			$sql="SELECT * FROM tbl_dependent WHERE status = 'Active' ORDER BY dependent_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveAllDependent() {
			$sql="SELECT * FROM tbl_dependent ORDER BY dependent_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveDependent($beneficiary_id) {
			$sql="SELECT * FROM tbl_dependent WHERE beneficiary_id = :beneficiary_id ORDER BY dependent_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => $beneficiary_id
			]);

			return $stmt->fetchAll();
		}

		public function addDependent() {
			$sql = "INSERT INTO `tbl_dependent`(`dependent_id`, `fullname`, `sex`, `civil_status_id`, `educational_attainment`, `occupation`, `status`, `voters_id`, `beneficiary_id`) VALUES (0, :fullname, :sex, :civil_status_id, :educational_attainment, :occupation, :status, :voters_id, :beneficiary_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":fullname" => $this->fullname,
				":sex" => $this->sex,
				":civil_status_id" => $this->civil_status_id,
				":educational_attainment" => $this->educational_attainment,
				":occupation" => $this->occupation,
				":status" => $this->status,
				":voters_id" => $this->voters_id,
				":beneficiary_id" => $this->beneficiary_id
			]);
		}

		public function updateDependent() {
			$sql="UPDATE `tbl_dependent` SET `dependent_id`= :dependent_id,`fullname`= :fullname,`sex`= :sex, `educational_attainment`= :educational_attainment,`occupation`= :occupation,`beneficiary_id`= :beneficiary_id WHERE `dependent_id`= :dependent_id";


			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":dependent_id" => $this->dependent_id,
				":fullname" => $this->fullname,
				":sex" => $this->sex,
				":educational_attainment" => $this->educational_attainment,
				":occupation" => $this->occupation,
				":beneficiary_id" => $this->beneficiary_id
			]);
		}

		public function deactivateDependent() {
			$sql="UPDATE `tbl_dependent` SET `dependent_id`= :dependent_id, `status` = :status WHERE `dependent_id`= :dependent_id";


			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":dependent_id" => $this->dependent_id,
				":status" => $this->status,
			]);
		}

		public function activateDependent() {
			$sql="UPDATE `tbl_dependent` SET `dependent_id`= :dependent_id, `status` = :status WHERE `dependent_id`= :dependent_id";


			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":dependent_id" => $this->dependent_id,
				":status" => $this->status,
			]);
		}

		public function deactivateAndNoBeneficiaryDependent() {
			$sql="UPDATE `tbl_dependent` SET `dependent_id`= :dependent_id, `status` = :status, `beneficiary_id` = :beneficiary_id WHERE `dependent_id`= :dependent_id";


			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":beneficiary_id" => $this->beneficiary_id,
				":dependent_id" => $this->dependent_id,
				":status" => $this->status,
			]);
		}

		public function searchDependent($filter, $keyword) {
			$sql="SELECT tbl_dependent.beneficiary_id, tbl_dependent.fullname, tbl_dependent.status, tbl_dependent.voters_id, tbl_dependent.civil_status_id, tbl_civil_status.description, tbl_dependent.sex FROM tbl_dependent INNER JOIN tbl_civil_status ON tbl_civil_status.civil_status_id = tbl_dependent.civil_status_id WHERE 
				CASE
					WHEN :filter = 'id' THEN (tbl_dependent.beneficiary_id LIKE :keyword)
					WHEN :filter = 'name' THEN (tbl_dependent.fullname LIKE :keyword)
					WHEN :filter = 'status' THEN (tbl_dependent.status LIKE :keyword)
					WHEN :filter = 'voters' THEN (tbl_dependent.voters_id LIKE :keyword)
					WHEN :filter = 'civil' THEN (tbl_dependent.civil_status_id LIKE :keyword)
					WHEN :filter = 'sex' THEN (tbl_dependent.sex LIKE :keyword)
				END
				ORDER BY beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
	}