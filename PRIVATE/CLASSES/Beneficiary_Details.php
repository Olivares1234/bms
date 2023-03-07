<?php
	
	class Beneficiary_Details {
		public $user_id;
		public $beneficiary_id;
		public $date_added;

		public $date_activated;
		public $date_updated;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function updateBeneficiaryDetails() {
			$sql="INSERT INTO `tbl_update_beneficiary_details`(`update_beneficiary_details_id`, `beneficiary_id`, `user_id`, `date_updated`) VALUES (0, :beneficiary_id, :user_id, :date_updated)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":user_id" => $this->user_id,
				":beneficiary_id" => $this->beneficiary_id,
				":date_updated" => $this->date_updated
			]);
		}

		public function activateBeneficiaryDetails() {
			$sql="INSERT INTO `tbl_activate_beneficiary_details`(`activate_beneficiary_details_id`, `beneficiary_id`, `user_id`, `date_activated`) VALUES (0, :beneficiary_id, :user_id, :date_activated)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":user_id" => $this->user_id,
				":beneficiary_id" => $this->beneficiary_id,
				":date_activated" => $this->date_activated
			]);
		}

		public function addBeneficiaryDetails() {
			$sql="INSERT INTO `tbl_beneficiary_details`(`beneficiary_details_id`, `beneficiary_id`, `user_id`, `date_added`) VALUES (0, :user_id, :beneficiary_id, :date_added)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":user_id" => $this->user_id,
				":beneficiary_id" => $this->beneficiary_id,
				":date_added" => $this->date_added
			]);
		}

	}