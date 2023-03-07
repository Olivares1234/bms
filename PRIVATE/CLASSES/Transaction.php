<?php

	class Transaction {
		public $transaction_id;
		public $beneficiary_id;
		public $user_id;
		public $transaction_date;
		public $date_start;
		public $date_end;
		public $barangay_id;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveTransaction($barangay_id) {
			$sql="SELECT * FROM `tbl_transaction` WHERE barangay_id = :barangay_id ORDER BY transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				"barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function getAllTransaction() {
			$sql="SELECT * FROM `tbl_transaction` ORDER BY transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addTransaction() {

			$sql="INSERT INTO `tbl_transaction`(`transaction_id`, `beneficiary_id`, `user_id`, `transaction_date`, `barangay_id`) VALUES (:transaction_id, :beneficiary_id, :user_id, :transaction_date, :barangay_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":transaction_id" => $this->transaction_id,
				":beneficiary_id" => $this->beneficiary_id,
				":user_id" => $this->user_id,
				":transaction_date" => $this->transaction_date,
				":barangay_id" => $this->barangay_id
			]);

		}

		public function searchEndAndStartDate() {
			$date_start = date('Y-m-d', strtotime($transaction_date));
			$date_end = date('Y-m-d', strtotime($transaction_date));

			$sql = "SELECT tbl_transaction_details.details_id, tbl_medicine.medicine_name, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price, tbl_user.first_name, tbl_user.last_name FROM tbl_transaction_details INNER JOIN tbl_transaction ON tbl_transaction_details.transaction_id = tbl_transaction.transaction_id INNER JOIN tbl_user ON tbl_transaction.user_id = tbl_user.user_id INNER JOIN tbl_medicine ON tbl_transaction_details.medicine_id = tbl_medicine.medicine_id WHERE transaction_id > :transaction_id AND transaction_date BETWEEN :date_start AND :date_end";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":date_start" => $date_start,
				":date_end" => $date_end
			]);

			return $stmt->fetchAll();
		}

		public function retreiveDateToday() {
			$transaction_date = date("Y-m-d");

			$sql = "SELECT tbl_transaction_details.details_id, tbl_transaction_details.transaction_id, tbl_medicine.medicine_name, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price, tbl_transaction_details.medicine_id, tbl_transaction.beneficiary_id FROM tbl_transaction_details INNER JOIN tbl_transaction ON tbl_transaction_details.transaction_id = tbl_transaction.transaction_id INNER JOIN tbl_medicine ON tbl_transaction_details.medicine_id = tbl_medicine.medicine_id WHERE DATE(transaction_date) = CURDATE()";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function searchTransaction($transaction_id, $barangay_id) {
			$sql = "SELECT * FROM `tbl_transaction` WHERE barangay_id = :barangay_id AND transaction_id LIKE :transaction_id ORDER BY transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":transaction_id" => '%' . $transaction_id . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}
	}