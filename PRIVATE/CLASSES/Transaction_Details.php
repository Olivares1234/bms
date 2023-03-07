<?php

	class Transaction_Details {
		public $details_id;
		public $transaction_id;
		public $price;	
		public $quantity;
		public $received_order_details_id;
		public $total_price;

		public $keyword;
	
		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}		

		public function retrieveTransactionDetails($beneficiary_id) {
			$sql="SELECT tbl_transaction_details.details_id, tbl_transaction.beneficiary_id, tbl_transaction.user_id, tbl_user.first_name, tbl_user.last_name, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction_details.total_price, tbl_transaction.transaction_date, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit FROM tbl_transaction_details INNER JOIN  tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_transaction.user_id INNER JOIN tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_transaction.beneficiary_id = :beneficiary_id AND tbl_transaction_details.quantity != 0 ORDER BY tbl_transaction_details.details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => $beneficiary_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveBeneficiaryTransaction($beneficiary_id) {
			$sql="SELECT tbl_transaction_details.transaction_id, tbl_transaction_details.supplier_medicine_id, tbl_supplier_medicine.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_transaction_details.quantity, tbl_supplier_medicine.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price, tbl_transaction.user_id, tbl_user.first_name, tbl_user.last_name FROM tbl_transaction_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_transaction_details.supplier_medicine_id INNER JOIN tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_transaction.user_id WHERE tbl_transaction.beneficiary_id = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => $beneficiary_id
			]);

			return $stmt->fetchAll();
		}
		
		public function addTransactionDetails() {
			$sql = "INSERT INTO `tbl_transaction_details`(`details_id`, `transaction_id`, `received_order_details_id`, `quantity`, `price`, `total_price`) VALUES (0, :transaction_id, :received_order_details_id, :quantity, :price, :total_price)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":transaction_id" => $this->transaction_id,
				":received_order_details_id" => $this->received_order_details_id,
				":quantity" => $this->quantity,
				":price" => $this->price,
				":total_price" => $this->total_price
			]);
		}

		public function updateTransactionDetails() {
			$sql = "UPDATE `tbl_transaction_details` SET `details_id`= :details_id,`transaction_id`= :transaction_id,`received_order_details_id`= :received_order_details_id,`quantity`= :quantity,`price`= :price,`total_price`= :total_price WHERE `details_id`= :details_id";

			$stmt1 = $this->connection->prepare($sql);

			return $stmt1->execute([
				":details_id" => $this->details_id,
				":transaction_id" => $this->transaction_id,
				":received_order_details_id" => $this->received_order_details_id,
				":price" => $this->price,
				":quantity" => $this->quantity,
				":total_price" => $this->total_price
			]);


		}

		public function getAllGulodTransactionDetails($beneficiary_id) {
			$sql="SELECT tbl_transaction_details.details_id, tbl_transaction_details.transaction_id, tbl_medicine.medicine_name, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price, tbl_transaction_details.medicine_id, tbl_transaction.beneficiary_id, tbl_user.first_name, tbl_user.last_name FROM tbl_transaction_details INNER JOIN tbl_transaction ON tbl_transaction_details.transaction_id = tbl_transaction.transaction_id INNER JOIN tbl_user ON tbl_transaction.user_id = tbl_user.user_id INNER JOIN tbl_medicine ON tbl_transaction_details.medicine_id = tbl_medicine.medicine_id WHERE tbl_user.barangay_id = 1 AND tbl_transaction.beneficiary_id = :beneficiary_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => $beneficiary_id
			]);

			return $stmt->fetchAll();
		}

		//start of searching for total transaction of beneficiary//
		public function getAllTransactionDetail() {
			$sql="SELECT tbl_transaction_details.details_id, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price FROM tbl_transaction_details INNER JOIN tbl_transaction ON tbl_transaction_details.transaction_id = tbl_transaction.transaction_id INNER JOIN tbl_beneficiary ON tbl_beneficiary.beneficiary_id = tbl_transaction.beneficiary_id ORDER BY tbl_transaction.transaction_date";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function searchForTransactionDetail($keyword) {
			$sql="SELECT tbl_beneficiary.beneficiary_id, tbl_transaction_details.details_id, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price FROM tbl_transaction_details INNER JOIN tbl_transaction ON tbl_transaction_details.transaction_id = tbl_transaction.transaction_id INNER JOIN tbl_beneficiary ON tbl_beneficiary.beneficiary_id = tbl_transaction.beneficiary_id WHERE tbl_beneficiary.beneficiary_id != null OR tbl_beneficiary.beneficiary_id LIKE :keyword";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
		//end of searching for total transaction of beneficiary//
		//tbl_transaction_details.details_id,

		public function retrieveTransactionDetailsForReturn($barangay_id, $transaction_id) {
			$sql="SELECT tbl_transaction_details.details_id, tbl_transaction_details.transaction_id, tbl_transaction_details.received_order_details_id, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction_details.total_price FROM tbl_transaction_details INNER JOIN tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id WHERE tbl_transaction_details.transaction_id = :transaction_id AND tbl_transaction.barangay_id = :barangay_id ORDER BY tbl_transaction_details.details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":transaction_id" => $transaction_id,
				":barangay_id" =>$barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function searchTransactionDetailsForReturn($filter, $keyword, $transaction_id) {
			$sql="SELECT tbl_transaction_details.details_id, tbl_transaction_details.transaction_id, tbl_transaction_details.received_order_details_id, tbl_transaction_details.quantity, tbl_transaction_details.price, tbl_transaction_details.total_price, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit FROM tbl_transaction_details INNER JOIN tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_transaction_details.transaction_id = :transaction_id AND 
				CASE
					WHEN :filter = 'medicine name' THEN (tbl_supplier_medicine.medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (tbl_category.description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (tbl_unit_category.unit LIKE :keyword)
				END
				ORDER BY tbl_transaction_details.details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":transaction_id" => $transaction_id,
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}

		public function getAllTransactionToday() { 
			$sql="SELECT tbl_transaction_details.transaction_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_transaction_details.quantity, tbl_supplier_medicine.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price FROM tbl_transaction_details  
			INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id  
			WHERE tbl_transaction_details.quantity != 0 AND tbl_barangay.barangay_id = $_SESSION[barangay_id] AND DATE(tbl_transaction.transaction_date) = CURDATE() 
			ORDER BY tbl_transaction_details.transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getAllBarangayTransactionToday() { 
			$sql="SELECT tbl_transaction_details.transaction_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_transaction_details.quantity, tbl_supplier_medicine.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price, tbl_transaction.barangay_id, tbl_barangay.barangay_id, tbl_barangay.barangay_name FROM tbl_transaction_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_transaction_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id INNER JOIN tbl_medicine ON tbl_medicine.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id INNER JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_medicine.barangay_id WHERE tbl_barangay.barangay_id = $_SESSION[barangay_id] AND tbl_transaction_details.quantity != 0 AND DATE(tbl_transaction.transaction_date) = CURDATE() ORDER BY tbl_transaction_details.transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getAllBarangayStartEndDate($start_date='', $end_date='') { 
			$sql="SELECT tbl_transaction_details.transaction_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_transaction_details.quantity, tbl_supplier_medicine.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price FROM tbl_transaction_details  INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id WHERE tbl_transaction_details.quantity != 0 AND tbl_barangay.barangay_id = $_SESSION[barangay_id] AND tbl_transaction.transaction_date BETWEEN :start_date AND :end_date ORDER BY tbl_transaction_details.transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":start_date" => $start_date,
				":end_date" => $end_date
			]);

			return $stmt->fetchAll();
		}

		public function getBeneficiaryTransaction($beneficiary_id="") {
			$sql="SELECT tbl_transaction_details.transaction_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_transaction_details.quantity, tbl_supplier_medicine.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price FROM tbl_transaction_details  
			INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id  
			WHERE tbl_transaction_details.quantity != 0 AND tbl_transaction.beneficiary_id LIKE :beneficiary_id
			ORDER BY tbl_transaction_details.transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => $beneficiary_id
			]);

			return $stmt->fetchAll();
		}

		public function getBeneficiaryTransactionStartEndDate($beneficiary_id, $start_date='', $end_date='') { 
			$sql="SELECT tbl_transaction_details.transaction_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_transaction_details.quantity, tbl_supplier_medicine.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price FROM tbl_transaction_details  INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id WHERE tbl_transaction_details.quantity != 0 AND tbl_transaction.beneficiary_id = :beneficiary_id AND tbl_transaction.transaction_date BETWEEN :start_date AND :end_date ORDER BY tbl_transaction_details.transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":beneficiary_id" => $beneficiary_id,
				":start_date" => $start_date,
				":end_date" => $end_date
			]);

			return $stmt->fetchAll();
		}


		public function getAllStartEndDate($start_date='', $end_date='') { 
			$sql="SELECT tbl_transaction_details.transaction_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_transaction_details.quantity, tbl_supplier_medicine.price, tbl_transaction.transaction_date, tbl_transaction_details.total_price FROM tbl_transaction_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_transaction_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id INNER JOIN tbl_medicine ON tbl_medicine.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id INNER JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_medicine.barangay_id WHERE tbl_barangay.barangay_id = $_SESSION[barangay_id] AND tbl_transaction_details.quantity != 0 AND tbl_transaction.transaction_date BETWEEN :start_date AND :end_date ORDER BY tbl_transaction_details.transaction_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":start_date" => $start_date,
				":end_date" => $end_date
			]);

			return $stmt->fetchAll();
		}

		public function getBestMedicine($search) {
			$sql="SELECT tbl_transaction_details.received_order_details_id, tbl_supplier_medicine.medicine_name
			AS 
				MedicineName, tbl_category.description 
			AS 
				Category, tbl_unit_category.unit 
			AS 
				Unit_Category, SUM(tbl_transaction_details.quantity)
			AS
				Quantity 
			FROM 
				tbl_transaction_details 
            INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id
            INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id 
			WHERE 
				tbl_barangay.barangay_id = $_SESSION[barangay_id] 
			AND
			(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_transaction.transaction_date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'last_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW()) - 1) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'this_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'last_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW()) - 1) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'this_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'last_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW()) - 1) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'this_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getBestBeneficiary($search) {
			$sql="SELECT tbl_transaction.beneficiary_id
			AS 
			Beneficiary,
			tbl_beneficiary.first_name, tbl_beneficiary.last_name, tbl_barangay.barangay_name, SUM(tbl_transaction_details.total_price) 
			AS 
				Total, COUNT(tbl_transaction_details.quantity) 
			AS
				Quantity
			FROM 
				tbl_transaction_details 
			INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id
			INNER JOIN tbl_beneficiary ON
				tbl_beneficiary.beneficiary_id = tbl_transaction.beneficiary_id
			WHERE 
				tbl_barangay.barangay_id = $_SESSION[barangay_id] AND
			(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_transaction.transaction_date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW())) GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'last_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW()) - 1) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'this_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW())) GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'last_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW()) - 1) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'this_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW())) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'last_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW()) - 1) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'this_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW())) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getBestBeneficiaryPerBarangay($barangay_id, $search) {
			$sql="SELECT tbl_transaction.beneficiary_id
			AS 
			Beneficiary,
			tbl_beneficiary.first_name, tbl_beneficiary.last_name, tbl_barangay.barangay_name, SUM(tbl_transaction_details.total_price) 
			AS 
				Total, COUNT(tbl_transaction_details.quantity) 
			AS
				Quantity
			FROM 
				tbl_transaction_details 
			INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id
			INNER JOIN tbl_beneficiary ON
				tbl_beneficiary.beneficiary_id = tbl_transaction.beneficiary_id
			WHERE 
				tbl_barangay.barangay_id = :barangay_id AND
			(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_transaction.transaction_date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW())) GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'last_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW()) - 1) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'this_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW())) GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'last_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW()) - 1) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'this_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW())) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'last_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW()) - 1) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
		            case 'this_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW())) 
		                	GROUP BY tbl_transaction.beneficiary_id
							ORDER BY Total DESC;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function getBestMedicinePerBarangay($barangay_id, $search) {
			$sql="SELECT tbl_transaction_details.received_order_details_id, tbl_supplier_medicine.medicine_name
			AS 
				MedicineName, tbl_category.description 
			AS 
				Category, tbl_unit_category.unit 
			AS 
				Unit_Category, SUM(tbl_transaction_details.quantity)
			AS
				Quantity 
			FROM 
				tbl_transaction_details 
            INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id
            INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id 
			WHERE 
				tbl_barangay.barangay_id = :barangay_id
			AND
			(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_transaction.transaction_date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'last_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW()) - 1) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'this_week':
		                $sql .= "WEEKOFYEAR(tbl_transaction.transaction_date) = WEEKOFYEAR(NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'last_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW()) - 1) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'this_month':
		                $sql .= "MONTH(tbl_transaction.transaction_date) = MONTH(NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'last_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW()) - 1) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
		            case 'this_year':
		                $sql .= "YEAR(tbl_transaction.transaction_date) = YEAR(NOW())) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		                	ORDER BY Quantity DESC;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function getDistributedMedicinePerBarangay($barangay_id, $search) {
			$sql="SELECT DATE_FORMAT(tbl_date.date, '%b %d') Day, SUM(IFNULL(tbl_transaction_details.total_price,0)) Amount,
				SUM(IFNULL(tbl_transaction_details.quantity,0))
				AS
				Quantity, COUNT(tbl_transaction.beneficiary_id)
				AS
				Beneficiary,
				FORMAT(IFNULL(tbl_transaction_details.total_price / SUM(tbl_transaction_details.total_price) * 100,0), 2) AS Amount_Average,
				FORMAT(IFNULL(tbl_transaction_details.quantity / SUM(tbl_transaction_details.quantity) * 100,0), 2) AS Quantity_Average,
				FORMAT(IFNULL(COUNT(tbl_transaction.beneficiary_id) / COUNT(tbl_transaction.beneficiary_id) * 100,0), 2) AS Beneficiary_Average
				FROM 
				(tbl_date
				LEFT JOIN 
				tbl_transaction ON tbl_date.date = tbl_transaction.transaction_date AND tbl_transaction.barangay_id = :barangay_id)
				LEFT JOIN 
				tbl_transaction_details ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
				WHERE 
				(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_date.date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW()))
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'last_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
							AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) - 1)
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'this_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
							AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) AND tbl_date.date <= now())
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'last_month':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
							AND MONTH(tbl_date.date) = MONTH(NOW()) - 1)
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'this_month':
		                $sql .= "(date between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()) AND tbl_date.date <= now())
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function getDistributedMedicinePerBarangayOfYear($barangay_id, $search) {
			$sql="SELECT DATE_FORMAT(tbl_date.date, '%b') Day, SUM(IFNULL(tbl_transaction_details.total_price,0)) Amount,
				SUM(IFNULL(tbl_transaction_details.quantity,0))
				AS
				Quantity, COUNT(tbl_transaction.beneficiary_id)
				AS
				Beneficiary,
				FORMAT(IFNULL(tbl_transaction_details.total_price / SUM(tbl_transaction_details.total_price) * 100,0), 2) AS Amount_Average,
				FORMAT(IFNULL(tbl_transaction_details.quantity / SUM(tbl_transaction_details.quantity) * 100,0), 2) AS Quantity_Average,
				FORMAT(IFNULL(COUNT(tbl_transaction.beneficiary_id) / COUNT(tbl_transaction.beneficiary_id) * 100,0), 2) AS Beneficiary_Average
				FROM 
				(tbl_date
				LEFT JOIN 
				tbl_transaction ON tbl_date.date = tbl_transaction.transaction_date AND tbl_transaction.barangay_id = :barangay_id)
				LEFT JOIN 
				tbl_transaction_details ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
				WHERE 
				(";
		        	switch($search){
		        		case 'last_year':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()) - 1)
							GROUP BY DATE_FORMAT(tbl_date.date, '%b')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'this_year':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()))
							GROUP BY DATE_FORMAT(tbl_date.date, '%b')
							ORDER BY tbl_date.date;";
		              		break;
				    }
			    ")";

				$stmt = $this->connection->prepare($sql);

				$stmt->execute([
					":barangay_id" => $barangay_id
				]);

				return $stmt->fetchAll();
		}

		public function overallBestMedicine() {
			$sql="SELECT tbl_transaction_details.received_order_details_id, tbl_supplier_medicine.medicine_name
			AS 
				MedicineName, tbl_category.description 
			AS 
				Category, tbl_unit_category.unit 
			AS 
				Unit_Category, SUM(tbl_transaction_details.quantity)
			AS
				Quantity
			FROM 
				tbl_transaction_details 
			INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id
            INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id 
			WHERE 
            MONTH(tbl_transaction.transaction_date) = MONTH(NOW()) GROUP BY tbl_supplier_medicine.supplier_medicine_id ASC
		    ORDER BY Quantity DESC";

		    $stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function topBarangay() {
			$sql="SELECT tbl_transaction_details.received_order_details_id, tbl_supplier_medicine.medicine_name
			AS 
				MedicineName, tbl_category.description 
			AS 
				Category, tbl_unit_category.unit 
			AS 
				Unit_Category, SUM(tbl_transaction_details.quantity)
			AS
				Quantity, tbl_transaction.barangay_id, tbl_barangay.barangay_name AS Barangay
			FROM 
				tbl_transaction_details 
			INNER JOIN 
            	tbl_received_order_details ON tbl_received_order_details.received_order_details_id = tbl_transaction_details.received_order_details_id
            INNER JOIN 
            	tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
			INNER JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id
            INNER JOIN 
            	tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id 
            INNER JOIN 
            	tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id
			INNER JOIN 
				tbl_transaction ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
			INNER JOIN 
				tbl_barangay ON tbl_barangay.barangay_id = tbl_transaction.barangay_id 
			WHERE 
            MONTH(tbl_transaction.transaction_date) = MONTH(NOW()) GROUP BY tbl_transaction.barangay_id
		    ORDER BY Quantity DESC";

		    $stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();

		}

		public function getDistributedMedicineDay($search) {
			$sql="SELECT DATE_FORMAT(tbl_date.date, '%b %d') Day, SUM(IFNULL(tbl_transaction_details.total_price,0)) Amount,
				SUM(IFNULL(tbl_transaction_details.quantity,0))
				AS
				Quantity, COUNT(tbl_transaction.beneficiary_id)
				AS
				Beneficiary,
				FORMAT(IFNULL(tbl_transaction_details.total_price / SUM(tbl_transaction_details.total_price) * 100,0), 2) AS Amount_Average,
				FORMAT(IFNULL(tbl_transaction_details.quantity / SUM(tbl_transaction_details.quantity) * 100,0), 2) AS Quantity_Average,
				FORMAT(IFNULL(COUNT(tbl_transaction.beneficiary_id) / COUNT(tbl_transaction.beneficiary_id) * 100,0), 2) AS Beneficiary_Average
				FROM 
				(tbl_date
				LEFT JOIN 
				tbl_transaction ON tbl_date.date = tbl_transaction.transaction_date AND tbl_transaction.barangay_id = $_SESSION[barangay_id])
				LEFT JOIN 
				tbl_transaction_details ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
				WHERE 
				(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_date.date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW()))
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'last_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
							AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) - 1)
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'this_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
							AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) AND tbl_date.date <= now())
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'last_month':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
							AND MONTH(tbl_date.date) = MONTH(NOW()) - 1)
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'this_month':
		                $sql .= "(date between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()) AND tbl_date.date <= now())
							GROUP BY DATE_FORMAT(tbl_date.date, '%b %d %a')
							ORDER BY tbl_date.date;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getDistributedMedicineYear($search) {
			$sql="SELECT DATE_FORMAT(tbl_date.date, '%b') Day, SUM(IFNULL(tbl_transaction_details.total_price,0)) Amount,
				SUM(IFNULL(tbl_transaction_details.quantity,0))
				AS
				Quantity, COUNT(tbl_transaction.beneficiary_id)
				AS
				Beneficiary,
				FORMAT(IFNULL(tbl_transaction_details.total_price / SUM(tbl_transaction_details.total_price) * 100,0), 2) AS Amount_Average,
				FORMAT(IFNULL(tbl_transaction_details.quantity / SUM(tbl_transaction_details.quantity) * 100,0), 2) AS Quantity_Average,
				FORMAT(IFNULL(COUNT(tbl_transaction.beneficiary_id) / COUNT(tbl_transaction.beneficiary_id) * 100,0), 2) AS Beneficiary_Average
				FROM 
				(tbl_date
				LEFT JOIN 
				tbl_transaction ON tbl_date.date = tbl_transaction.transaction_date AND tbl_transaction.barangay_id = $_SESSION[barangay_id])
				LEFT JOIN 
				tbl_transaction_details ON tbl_transaction.transaction_id = tbl_transaction_details.transaction_id
				WHERE 
				(";
		        	switch($search){
		        		case 'last_year':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()) - 1)
							GROUP BY DATE_FORMAT(tbl_date.date, '%b')
							ORDER BY tbl_date.date;";
		              		break;
		            case 'this_year':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()))
							GROUP BY DATE_FORMAT(tbl_date.date, '%b')
							ORDER BY tbl_date.date;";
		              		break;
				    }
			    ")";

				$stmt = $this->connection->prepare($sql);

				$stmt->execute();

				return $stmt->fetchAll();
		}
	}