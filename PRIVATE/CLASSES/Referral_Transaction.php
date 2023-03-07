<?php

	class Referral_Transaction {
		public $referral_transaction_id;
		public $beneficiary_id;
		public $user_id;
		public $referral_transaction_date;
		public $barangay_id;


		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveReferralTransaction() {
			$sql = "SELECT * FROM tbl_referral_transaction";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addReferralTransaction() {
			$sql = "INSERT INTO `tbl_referral_transaction`(`referral_transaction_id`, `beneficiary_id`, `user_id`, `referral_transaction_date`, `barangay_id`) VALUES (:referral_transaction_id, :beneficiary_id, :user_id, :referral_transaction_date, :barangay_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":referral_transaction_id" => $this->referral_transaction_id,
				":beneficiary_id" => $this->beneficiary_id,
				":user_id" => $this->user_id,
				":referral_transaction_date" => $this->referral_transaction_date,
				":barangay_id" => $this->barangay_id

			]);
		}

		public function searchReferralTransaction($keyword) {
			$sql = "SELECT referral_transaction_id, referral_transaction_date FROM tbl_referral_transaction WHERE referral_transaction_id LIKE :keyword OR referral_transaction_date LIKE :keyword";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
	}