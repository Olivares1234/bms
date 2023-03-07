<?php

	class Request_Details {
		public $request_details_id;
		public $request_order_id;
		public $purchase_received_details_id;
		public $delivered_quantity;
		public $request_details_status;
		
		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}
 
		public function retrieveRequestDetails($request_order_id) {
			$sql="SELECT * FROM tbl_request_details WHERE request_order_id = :request_order_id ORDER BY request_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":request_order_id"=> $request_order_id
			]);

			return $stmt->fetchAll();
		}

		public function addRequestDetails() {
			$sql="INSERT INTO `tbl_request_details`(`request_details_id`, `request_order_id`, `purchase_received_details_id`, `delivered_quantity`) VALUES (0, :request_order_id, :purchase_received_details_id, :delivered_quantity)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":request_order_id" => $this->request_order_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":delivered_quantity" => $this->delivered_quantity
			]);
		}

		public function updateRequestDetails() {
			$sql="UPDATE `tbl_request_details` SET `delivered_quantity` = :delivered_quantity  WHERE `tbl_request_details`.`request_details_id` = :request_details_id AND `tbl_request_details`.`purchase_received_details_id` = :purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":request_details_id" => $this->request_details_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":delivered_quantity" => $this->delivered_quantity,
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

		public function searchRequestOrderDetails($request_order_id, $filter, $keyword) {
			$sql="SELECT tbl_request_details.purchase_received_details_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_supplier_medicine.category_id, tbl_unit_category.unit, tbl_supplier_medicine.unit_category_id, tbl_supplier.supplier_name, tbl_supplier_medicine.supplier_id, tbl_supplier_medicine.price, tbl_request_details.delivered_quantity FROM tbl_request_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_request_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE tbl_request_details.request_order_id = :request_order_id AND

			(";
		        switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)";
		              		break;
		            case 'price':
		                $sql .= "tbl_supplier_medicine.price LIKE :keyword)";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":request_order_id"=> $request_order_id,
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
	}