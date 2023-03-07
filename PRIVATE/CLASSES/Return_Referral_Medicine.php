<?php
	
	class Return_Referral_Medicine {
		public $return_referral_medicine_id;
		public $beneficiary_id;
		public $user_id;
		public $date_return;
		public $referral_transaction_id;
		public $return_referral_date;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}


		public function addReturnReferralMedicine() {
			$sql="INSERT INTO `tbl_return_referral_medicine`(`return_referral_medicine_id`, `beneficiary_id`, `user_id`, `referral_transaction_id`, `return_referral_date`) VALUES (:return_referral_medicine_id, :beneficiary_id, :user_id, :referral_transaction_id, :return_referral_date)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":return_referral_medicine_id" => $this->return_referral_medicine_id,
				":beneficiary_id" => $this->beneficiary_id,
				":user_id" => $this->user_id,
				":referral_transaction_id" => $this->referral_transaction_id,
				":return_referral_date" => $this->return_referral_date
			]);
		}

		public function retrieveReturnMedicine() {
			$sql = "SELECT * FROM `tbl_return_referral_medicine` ORDER BY return_referral_medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function searchReturnMedicine($keyword) {
			$sql="SELECT `referral_transaction_id`, `date_return` FROM return_referral_medicine WHERE referral_transaction_id LIKE :keyword OR date_return LIKE :keyword ORDER BY referral_transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
	}