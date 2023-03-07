<?php

	class Referral_Transaction_Details {
		public $referral_transaction_details_id;
		public $referral_transaction_id;
		public $purchase_received_details_id;
		public $quantity;
		public $price;
		public $total_price;


		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveReferralTransactionDetails($referral_transaction_id) {
			$sql = "SELECT * FROM tbl_referral_transaction_details WHERE referral_transaction_id = :referral_transaction_id ORDER BY referral_transaction_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":referral_transaction_id" => $referral_transaction_id
			]);

			return $stmt->fetchAll();
		}

		public function addReferralTransactionDetails() {
			$sql = "INSERT INTO `tbl_referral_transaction_details`(`referral_transaction_details_id`, `referral_transaction_id`, `purchase_received_details_id`, `quantity`, `price`, `total_price`) VALUES (0, :referral_transaction_id, :purchase_received_details_id, :quantity, :price, :total_price)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":referral_transaction_id" => $this->referral_transaction_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":quantity" => $this->quantity,
				":price" => $this->price,
				":total_price" => $this->total_price
			]);
		}

		public function updateReferralTransactionDetails() {
			$sql = "UPDATE `tbl_referral_transaction_details` SET `referral_transaction_details_id`= :referral_transaction_details_id,`referral_transaction_id`= :referral_transaction_id, `purchase_received_details_id`= :purchase_received_details_id, `quantity`= :quantity, `price`= :price, `total_price`= :total_price WHERE `referral_transaction_details_id` = :referral_transaction_details_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":referral_transaction_details_id" => $this->referral_transaction_details_id,
				":referral_transaction_id" => $this->referral_transaction_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":quantity" => $this->quantity,
				":price" => $this->price,
				":total_price" => $this->total_price
			]);
		}

		public function searchReferralTransactionDetails($referral_transaction_id, $filter, $keyword) {
			$sql="SELECT tbl_purchase_received_details.purchase_received_details_id, tbl_supplier_medicine.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_referral_transaction_details.quantity, tbl_referral_transaction_details.price, tbl_referral_transaction_details.total_price FROM tbl_referral_transaction_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_referral_transaction_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE referral_transaction_id = :referral_transaction_id AND
			(";
		        switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)
		                ORDER BY referral_transaction_details_id;";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)
		                ORDER BY referral_transaction_details_id;";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)
		                ORDER BY referral_transaction_details_id;";
		              		break;
		            case 'price':
		                $sql .= "tbl_supplier_medicine.price LIKE :keyword)
		                ORDER BY referral_transaction_details_id;";
		              		break;
			    }
		    ")";

		    $stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":referral_transaction_id" => $referral_transaction_id,
				":keyword" => "%" . $keyword . "%"
			]);

			return $stmt->fetchAll();
		}
	}