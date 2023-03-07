<?php
	
	class Return_Medicine {
		public $return_medicine_id;
		public $transaction_id;
		public $beneficiary_id;
		public $user_id;
		public $date_return;
		public $barangay_id;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}


		public function addReturnMedicine() {
			$sql="INSERT INTO `tbl_return_medicine`(`return_medicine_id`, `beneficiary_id`, `user_id`, `transaction_id`, `date_return`, `barangay_id`) VALUES (:return_medicine_id, :beneficiary_id, :user_id, :transaction_id, :date_return, :barangay_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":return_medicine_id" => $this->return_medicine_id,
				":beneficiary_id" => $this->beneficiary_id,
				":user_id" => $this->user_id,
				":transaction_id" => $this->transaction_id,
				":date_return" => $this->date_return,
				":barangay_id" => $this->barangay_id
			]);
		}

		public function retrieveReturnMedicine() {
			$sql = "SELECT * FROM `tbl_return_medicine` ORDER BY return_medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}