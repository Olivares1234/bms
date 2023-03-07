<?php

	class Purchase_Order {
		public $purchase_order_id;
		public $user_id;
		public $date_ordered;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveAllPurchaseOrder() {
			$sql="SELECT * FROM `tbl_purchase_order` INNER JOIN tbl_user ON tbl_user.user_id = tbl_purchase_order.user_id INNER JOIN tbl_purchase_order_details ON tbl_purchase_order_details.purchase_order_id = tbl_purchase_order.purchase_order_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_order_details.supplier_medicine_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id ORDER BY date_ordered";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addPurchaseOrder() {
			$sql="INSERT INTO `tbl_purchase_order`(`purchase_order_id`, `user_id`, `date_ordered`) VALUES (:purchase_order_id, :user_id, :date_ordered)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":purchase_order_id" => $this->purchase_order_id,
				":user_id" => $this->user_id,
				":date_ordered" => $this->date_ordered
			]);
		}

		public function searchPurchaseOrder($keyword) {
			$sql="SELECT `purchase_order_id`, `date_ordered` FROM tbl_purchase_order WHERE purchase_order_id LIKE :keyword OR date_ordered LIKE :keyword ORDER BY purchase_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
	}