<?php

	class Send_Order {
		public $send_order_id;
		public $user_id;
		public $request_order_id;
		public $date_send;
		public $barangay_id;

		public $supplier_medicine_id;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function getAllBarangay() {
			$sql = "SELECT * FROM tbl_barangay";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getSendOrder($barangay_id) {
			$sql="SELECT tbl_send_order.send_order_id, tbl_send_order.date_send, tbl_send_order.barangay_id FROM `tbl_send_order` WHERE tbl_send_order.barangay_id = :barangay_id ORDER BY tbl_send_order.send_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveSendOrder() {
			$sql = "SELECT * FROM `tbl_send_order` WHERE 1";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addSendOrder() {
			$sql = "INSERT INTO `tbl_send_order`(`send_order_id`, `user_id`, `request_order_id`, `date_send`, `barangay_id`) VALUES (:send_order_id, :user_id, :request_order_id, :date_send, :barangay_id)";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":send_order_id" => $this->send_order_id,
				":user_id" => $this->user_id,
				":request_order_id" => $this->request_order_id,
				":date_send" => $this->date_send,
				":barangay_id" => $this->barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function searchSendOrder($keyword, $barangay_id) {
			$sql="SELECT tbl_send_order.send_order_id, tbl_send_order.date_send, tbl_send_order.barangay_id FROM `tbl_send_order` WHERE tbl_send_order.barangay_id = :barangay_id AND (tbl_send_order.send_order_id LIKE :keyword OR tbl_send_order.date_send LIKE :keyword) ORDER BY tbl_send_order.send_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":keyword" => "%" . $keyword . "%"
			]);

			return $stmt->fetchAll();
		}
	}