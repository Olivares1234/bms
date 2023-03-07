<?php
 
	class Send_Details {
		public $send_details_id;
		public $send_order_id;
		public $purchase_received_details_id;
		public $quantity;
		public $received_quantity;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function searchSendDetails($barangay_id, $keyword, $filter, $send_order_id) {
			$sql="SELECT tbl_send_details.send_details_id, tbl_send_details.send_order_id, tbl_send_details.purchase_received_details_id, tbl_send_details.quantity, tbl_send_details.received_quantity, tbl_purchase_received_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_send_order.barangay_id FROM tbl_send_details INNER JOIN tbl_send_order ON tbl_send_order.send_order_id = tbl_send_details.send_order_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_send_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_send_order.barangay_id = :barangay_id AND tbl_send_order.send_order_id = :send_order_id AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				ORDER BY tbl_send_details.send_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":send_order_id" => $send_order_id,
				":filter" => $filter,
				":keyword" => "%" . $keyword . "%"

			]);

			return $stmt->fetchAll();
		}

		public function addSendDetails() {
			$sql = "INSERT INTO `tbl_send_details`(`send_details_id`, `send_order_id`, `purchase_received_details_id`, `quantity`, `received_quantity`) VALUES (0, :send_order_id, :purchase_received_details_id, :quantity, :received_quantity)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":send_order_id" => $this->send_order_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":quantity" => $this->quantity,
				":received_quantity" => $this->received_quantity
			]);

			// return $stmt->fetchAll();
		}

		public function retrieveSendDetails($send_order_id) {
			$sql="SELECT * FROM tbl_send_details WHERE send_order_id = :send_order_id ORDER BY send_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":send_order_id" => $send_order_id
			]);

			return $stmt->fetchAll();
		}

		public function updateSendDetails() {
			$sql="UPDATE `tbl_send_details` SET `send_details_id`= :send_details_id,`received_quantity`= :received_quantity WHERE `send_details_id`= :send_details_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":send_details_id" => $this->send_details_id,
				":received_quantity" => $this->received_quantity
			]);
		}
	}