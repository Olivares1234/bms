<?php

	class Purchase_Received {
		public $purchase_received_id;
		public $user_id;
		public $date_received;
		public $purchase_order_id;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrievePurchaseReceived() {
			$sql="SELECT * FROM `tbl_purchase_received` WHERE 1";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addPurchaseReceived() {
			$sql="INSERT INTO `tbl_purchase_received`(`purchase_received_id`, `user_id`, `purchase_order_id`, `date_received`) VALUES (:purchase_received_id, :user_id, :purchase_order_id, :date_received)";
			
			$stmt = $this->connection->prepare($sql);


			return $stmt->execute([
				":purchase_received_id" => $this->purchase_received_id,
				":user_id" => $this->user_id,
				":purchase_order_id" => $this->purchase_order_id,
				":date_received" => $this->date_received
			]);
		}
	}