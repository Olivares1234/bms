<?php
	
	class Return_Referral_Medicine_Details {
		public $return_referral_medicine_details_id;
		public $return_referral_medicine_id;
		public $purchase_received_details_id;
		public $quantity;
		public $total_amount;
		public $remarks;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveReturnedMedicine() {
			$sql = "SELECT tbl_return_referral_medicine_details.return_referral_medicine_details_id, tbl_return_referral_medicine_details.return_referral_medicine_id, tbl_return_referral_medicine_details.purchase_received_details_id, tbl_return_referral_medicine_details.quantity AS quantity, tbl_return_referral_medicine_details.total_amount, tbl_return_referral_medicine_details.remarks, tbl_supplier_medicine.supplier_medicine_id FROM tbl_return_referral_medicine_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_return_referral_medicine_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_return_referral_medicine_details.return_referral_medicine_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addReturnReferralMedicineDetails() {
			$sql="INSERT INTO `tbl_return_referral_medicine_details`(`return_referral_medicine_details_id`, `return_referral_medicine_id`, `purchase_received_details_id`, `quantity`, `total_amount`, `remarks`) VALUES (0, :return_referral_medicine_id, :purchase_received_details_id, :quantity, :total_amount, :remarks)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":return_referral_medicine_id" => $this->return_referral_medicine_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":quantity" => $this->quantity,
				":total_amount" => $this->total_amount,
				":remarks" => $this->remarks
			]);
		}

		public function retrieveReturnReferralMedicineDetails($referral_transaction_id) {
			$sql = "SELECT tbl_return_referral_medicine_details.return_referral_medicine_details_id, tbl_return_referral_medicine_details.return_referral_medicine_id, tbl_return_referral_medicine_details.purchase_received_details_id, tbl_return_referral_medicine_details.quantity, tbl_return_referral_medicine_details.total_amount, tbl_return_referral_medicine.beneficiary_id, tbl_return_referral_medicine.return_referral_date, tbl_return_referral_medicine_details.remarks, tbl_barangay.barangay_name, tbl_user.first_name, tbl_user.last_name FROM tbl_return_referral_medicine_details INNER JOIN tbl_return_referral_medicine ON tbl_return_referral_medicine.return_referral_medicine_id = tbl_return_referral_medicine_details.return_referral_medicine_id INNER JOIN tbl_beneficiary ON tbl_beneficiary.beneficiary_id = tbl_return_referral_medicine.beneficiary_id INNER JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_beneficiary.barangay_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_return_referral_medicine.user_id WHERE tbl_return_referral_medicine.referral_transaction_id = :referral_transaction_id ORDER BY tbl_return_referral_medicine_details.return_referral_medicine_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":referral_transaction_id" => $referral_transaction_id
			]);

			return $stmt->fetchAll();
		}

		public function searchReturnedMedicine($filter, $keyword) {
			$sql = "SELECT * FROM tbl_return_referral_medicine_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_return_referral_medicine_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE quantity > 0 AND

			(";
		        switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)
		                ORDER BY tbl_return_referral_medicine_details.return_referral_medicine_details_id;";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)
		                ORDER BY tbl_return_referral_medicine_details.return_referral_medicine_details_id;";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)
		                ORDER BY tbl_return_referral_medicine_details.return_referral_medicine_details_id;";
		              		break;
		            case 'price':
		                $sql .= "tbl_supplier_medicine.price LIKE :keyword)
		                ORDER BY tbl_return_referral_medicine_details.return_referral_medicine_details_id;";
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