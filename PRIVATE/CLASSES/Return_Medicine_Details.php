<?php
	
	class Return_Medicine_Details {
		public $return_medicine_details_id;
		public $return_medicine_id;
		public $received_order_details_id;
		public $quantity;
		public $total_amount;
		public $remarks;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveReturnedMedicine() {
			$sql="SELECT tbl_return_medicine_details.return_medicine_details_id, tbl_return_medicine_details.return_medicine_id, tbl_return_medicine_details.received_order_details_id, tbl_return_medicine_details.remarks, tbl_purchase_received_details.purchase_received_details_id, tbl_return_medicine_details.quantity as Quantity FROM tbl_return_medicine_details INNER JOIN tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_return_medicine_details.received_order_details_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id ORDER BY tbl_return_medicine_details.return_medicine_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveReturnMedicineDetails($transaction_id) {
			$sql="SELECT tbl_return_medicine_details.return_medicine_details_id,tbl_return_medicine_details.quantity,tbl_return_medicine_details.total_amount, tbl_return_medicine.beneficiary_id, tbl_return_medicine.user_id, tbl_user.first_name, tbl_user.last_name, tbl_return_medicine.date_return, tbl_return_medicine.barangay_id, tbl_barangay.barangay_name FROM tbl_return_medicine_details INNER JOIN tbl_return_medicine ON tbl_return_medicine.return_medicine_id = tbl_return_medicine_details.return_medicine_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_return_medicine.user_id INNER JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_return_medicine.barangay_id WHERE tbl_return_medicine.transaction_id = :transaction_id ORDER BY tbl_return_medicine_details.return_medicine_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":transaction_id" => $transaction_id
			]);

			return $stmt->fetchAll();
		}


		public function addReturnMedicineDetails() {
			$sql="INSERT INTO `tbl_return_medicine_details`(`return_medicine_details_id`, `return_medicine_id`, `received_order_details_id`, `quantity`, `total_amount`, `remarks`) VALUES (0, :return_medicine_id, :received_order_details_id, :quantity, :total_amount, :remarks)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":return_medicine_id" => $this->return_medicine_id,
				":received_order_details_id" => $this->received_order_details_id,
				":quantity" => $this->quantity,
				":total_amount" => $this->total_amount,
				":remarks" => $this->remarks
			]);
		}

		public function searchReturnedMedicine($filter, $keyword) {
			$sql = "SELECT tbl_return_medicine_details.return_medicine_details_id, tbl_return_medicine_details.return_medicine_id, tbl_return_medicine_details.received_order_details_id, tbl_return_medicine_details.remarks, tbl_purchase_received_details.purchase_received_details_id, tbl_return_medicine_details.quantity as Quantity FROM tbl_return_medicine_details INNER JOIN tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_return_medicine_details.received_order_details_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE

			(";
		        switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)
		                ORDER BY tbl_return_medicine_details.return_medicine_details_id;";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)
		                ORDER BY tbl_return_medicine_details.return_medicine_details_id;";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)
		                ORDER BY tbl_return_medicine_details.return_medicine_details_id;";
		              		break;
		            case 'price':
		                $sql .= "tbl_supplier_medicine.price LIKE :keyword)
		                ORDER BY tbl_return_medicine_details.return_medicine_details_id;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => "%" . $keyword . "%"
			]);

			return $stmt->fetchAll();
		}
	}