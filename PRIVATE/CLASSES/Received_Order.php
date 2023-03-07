<?php

	class Received_Order {
		public $received_order_id;
		public $send_order_id;
		public $user_id;
		public $date_received;
		public $barangay_id;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function addReceivedOrder() {
			$sql="INSERT INTO `tbl_received_order`(`received_order_id`, `send_order_id`, `user_id`, `date_received`, `barangay_id`) VALUES ( :received_order_id, :send_order_id, :user_id, :date_received, :barangay_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":received_order_id" => $this->received_order_id,
				":send_order_id" => $this->send_order_id,
				":user_id" => $this->user_id,
				":date_received" => $this->date_received,
				":barangay_id" => $this->barangay_id
			]);
		}

		public function retrieveReceivedOrder() {
			$sql="SELECT * FROM `tbl_received_order` ORDER BY received_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}