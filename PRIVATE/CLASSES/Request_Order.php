<?php

	class Request_Order {
		public $request_order_id;
		public $user_id;
		public $date_request;
		public $barangay_id;
		public $request_order_status;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveRequestPerBarangay($barangay_id) {
			$sql="SELECT * FROM `tbl_request_order` WHERE barangay_id = :barangay_id ORDER BY request_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveRequestOrder() {
			$sql="SELECT * FROM `tbl_request_order` ORDER BY request_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addRequestOrder() {
			$sql="INSERT INTO `tbl_request_order`(`request_order_id`, `user_id`, `date_request`, `barangay_id`, `request_order_status`) VALUES (:request_order_id, :user_id, :date_request, :barangay_id, :request_order_status)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":request_order_id" => $this->request_order_id,
				":user_id" => $this->user_id,
				":date_request" => $this->date_request,
				":barangay_id" => $this->barangay_id,
				":request_order_status" => $this->request_order_status
			]);
		}

		public function searchPurchaseOrder($purchase_order_id) {
			$sql="SELECT `purchase_order_id`, `date_ordered` FROM tbl_purchase_order WHERE purchase_order_id LIKE :purchase_order_id ORDER BY purchase_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":purchase_order_id" => '%' . $purchase_order_id . '%'
			]);

			return $stmt->fetchAll();
		}

		public function getBarangayRequestOrder() {
			$sql="SELECT tbl_request_order.request_order_id, tbl_request_order.date_request, tbl_request_order.barangay_id, tbl_request_order.request_order_status, tbl_barangay.barangay_id, tbl_barangay.barangay_name, tbl_barangay.contact_no FROM `tbl_request_order` INNER JOIN `tbl_barangay` ON tbl_barangay.barangay_id = tbl_request_order.barangay_id ORDER BY tbl_request_order.request_order_id DESC";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function searchRequestOrder($filter, $keyword) {
			$sql="SELECT tbl_request_order.request_order_id, tbl_request_order.date_request, tbl_request_order.request_order_status, tbl_barangay.barangay_id, tbl_barangay.barangay_name FROM tbl_request_order INNER JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_request_order.barangay_id WHERE

			(";
		        switch($filter){
		            case 'id':
		                $sql .= "tbl_request_order.request_order_id LIKE :keyword)";
		              		break;
		            case 'date':
		                $sql .= "tbl_request_order.date_request LIKE :keyword)";
		              		break;
		            case 'status':
		                $sql .= "tbl_request_order.request_order_status LIKE :keyword)";
		              		break;
		            case 'barangay':
		                $sql .= "tbl_barangay.barangay_name LIKE :keyword)";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => "%" . $keyword . "%"
			]);

			return $stmt->fetchAll();
		}

		public function updateRequestOrder() {
			$sql="UPDATE `tbl_request_order` SET `request_order_status` = :request_order_status  WHERE `tbl_request_order`.`request_order_id` = :request_order_id ";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":request_order_id" => $this->request_order_id,
				":request_order_status" => $this->request_order_status
			]);
		}
	}