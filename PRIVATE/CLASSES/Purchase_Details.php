<?php

	class Purchase_Details {
		public $purchase_details_id;
		public $purchase_order_id;
		public $supplier_medicine_id;
		public $quantity;
		public $received_quantity;

		public $search_purchase_details;
		
		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrievePurchaseDetails($purchase_order_id) {
			$sql="SELECT tbl_purchase_details.purchase_details_id, tbl_purchase_details.purchase_order_id, tbl_purchase_details.supplier_medicine_id, tbl_purchase_details.quantity, tbl_purchase_details.received_quantity, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_supplier_medicine.category_id, tbl_unit_category.unit, tbl_supplier_medicine.unit_category_id, tbl_supplier.supplier_name, tbl_supplier_medicine.supplier_id, tbl_supplier_medicine.price FROM tbl_purchase_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE tbl_purchase_details.purchase_order_id = :purchase_order_id ORDER BY tbl_purchase_details.purchase_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":purchase_order_id"=> $purchase_order_id
			]);

			return $stmt->fetchAll();
		}

		public function addPurchaseDetails() {
			$sql="INSERT INTO `tbl_purchase_details`(`purchase_details_id`, `purchase_order_id`, `supplier_medicine_id`, `quantity`, `received_quantity`) VALUES (0, :purchase_order_id, :supplier_medicine_id, :quantity, :received_quantity)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":purchase_order_id" => $this->purchase_order_id,
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":quantity" => $this->quantity,
				":received_quantity" => $this->received_quantity
			]);
		}

		public function updatePurchaseDetails() {
			$sql="UPDATE `tbl_purchase_details` SET `purchase_details_id`= :purchase_details_id,`purchase_order_id`= :purchase_order_id,`supplier_medicine_id`= :supplier_medicine_id,`quantity`= :quantity,`received_quantity`= :received_quantity WHERE `purchase_details_id` = :purchase_details_id ";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":purchase_details_id" => $this->purchase_details_id,
				":purchase_order_id" => $this->purchase_order_id,
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":quantity" => $this->quantity,
				":received_quantity" => $this->received_quantity
			]);
		}

		public function searchPurchaseDetails() {
			$sql = "SELECT tbl_purchase_details.purchase_details_id, tbl_purchase_details.purchase_order_id, tbl_purchase_details.supplier_medicine_id, tbl_purchase_details.quantity, tbl_purchase_details.received_quantity, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_supplier_medicine.category_id, tbl_unit_category.unit, tbl_supplier_medicine.unit_category_id, tbl_supplier.supplier_name, tbl_supplier_medicine.supplier_id, tbl_supplier_medicine.price FROM tbl_purchase_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE tbl_purchase_details.purchase_order_id = :purchase_order_id AND (tbl_supplier_medicine.medicine_name LIKE :search_purchase_details OR tbl_category.description LIKE :search_purchase_details OR tbl_unit_category.unit LIKE :search_purchase_details)  ORDER BY tbl_purchase_details.purchase_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":purchase_order_id" => $this->purchase_order_id,
				":search_purchase_details" => "%" . $this->search_purchase_details . "%"
			]);

			return $stmt->fetchAll();
		}

		public function searchPurchaseReceivedDetails($purchase_order_id, $filter, $keyword) {
			$sql = "SELECT tbl_purchase_details.purchase_details_id, tbl_purchase_details.purchase_order_id, tbl_purchase_details.supplier_medicine_id, tbl_purchase_details.quantity, tbl_purchase_details.received_quantity, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_supplier_medicine.category_id, tbl_unit_category.unit, tbl_supplier_medicine.unit_category_id, tbl_supplier.supplier_name, tbl_supplier_medicine.supplier_id, tbl_supplier_medicine.price FROM tbl_purchase_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE tbl_purchase_details.purchase_order_id = :purchase_order_id AND

			(";
		        switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)
		                ORDER BY tbl_purchase_details.purchase_details_id";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)
		                ORDER BY tbl_purchase_details.purchase_details_id";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)
		                ORDER BY tbl_purchase_details.purchase_details_id";
		              		break;
		            case 'stock':
		                $sql .= "tbl_purchase_details.quantity LIKE :keyword)
		                ORDER BY tbl_purchase_details.purchase_details_id";
		              		break;
		            case 'received':
		                $sql .= "tbl_purchase_details.received_quantity LIKE :keyword)
		                ORDER BY tbl_purchase_details.purchase_details_id";
		              		break;
			    }
		    ")";

		    $stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":purchase_order_id" => $purchase_order_id,
				":keyword" => "%" . $keyword . "%"
			]);

			return $stmt->fetchAll();
		}
	}