<?php

	class Purchase_Order_Details {
		public $purchase_order_details_id;
		public $purchase_order_id;
		public $supplier_medicine_id;
		public $quantity;
		public $price;
		public $supplier_id;

		public $keyword;
		
		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveAllPurchaseOrderDetails() {
			$sql="SELECT * FROM `tbl_purchase_order_details` ORDER BY purchase_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addPurchaseOrderDetails() {
			$sql="INSERT INTO `tbl_purchase_order_details`(`purchase_order_details_id`, `purchase_order_id`, `supplier_medicine_id`, `quantity`) VALUES (0, :purchase_order_id, :supplier_medicine_id, :quantity)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":purchase_order_id" => $this->purchase_order_id,
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":quantity" => $this->quantity
			]);
		}

		public function updatePurchaseOrderDetails() {
			$sql="UPDATE `tbl_purchase_order_details` SET `purchase_order_details_id` = :purchase_order_details_id, `purchase_order_id` = :purchase_order_id, `supplier_medicine_id` = :supplier_medicine_id, `quantity` = :quantity, `supplier_id` = :supplier_id WHERE purchase_order_details_id = :purchase_order_details_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":purchase_order_details_id" => $this->purchase_order_details_id,
				":purchase_order_id" => $this->purchase_order_id,
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":quantity" => $this->quantity,
				":supplier_id" => $this->supplier_id

			]);
		}

		public function getPurchaseOrderDetails($purchase_order_id) {
			$sql="SELECT * FROM `tbl_purchase_details` INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_details.supplier_medicine_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE purchase_order_id = :purchase_order_id ORDER BY purchase_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":purchase_order_id" => $purchase_order_id
			]);

			return $stmt->fetchAll();
		}

		public function getPurchaseOrdersReports($search) {
			$sql="SELECT DATE_FORMAT(tbl_date.date, '%b %d') AS Date_Request, COUNT(tbl_purchase_order_details.purchase_order_id) AS Total_Order, COALESCE(tbl_supplier.supplier_name, 'Null') AS Supplier FROM tbl_date LEFT JOIN tbl_purchase_order ON tbl_purchase_order.date_ordered = tbl_date.date LEFT JOIN tbl_purchase_order_details ON tbl_purchase_order_details.purchase_order_id = tbl_purchase_order.purchase_order_id LEFT JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_order_details.supplier_medicine_id LEFT JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE
				(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_date.date BETWEEN DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW()))
		                	GROUP BY tbl_date.date ORDER BY DATE(tbl_date.date);";
		              		break;
		            case 'last_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()) AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) - 1) 
		                	GROUP BY tbl_date.date ORDER BY DATE(tbl_date.date);";
		              		break;
		            case 'this_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()) AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) AND tbl_date.date <= now())
		                	GROUP BY tbl_date.date ORDER BY DATE(tbl_date.date);";
		              		break;
		            case 'last_month':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()) AND MONTH(tbl_date.date) = MONTH(NOW()) - 1) 
		                	GROUP BY tbl_date.date ORDER BY DATE(tbl_date.date);";
		              		break;
		            case 'this_month':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()) AND MONTH(tbl_date.date) = MONTH(NOW()) AND tbl_date.date <= now()) 
		                	GROUP BY tbl_date.date ORDER BY DATE(tbl_date.date);";
		              		break;
		            case 'last_year':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW()) - 1) 
		                	GROUP BY DATE_FORMAT(tbl_date.date, '%b') ORDER BY DATE(tbl_date.date);";
		              		break;
		            case 'this_year':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())) 
		                	GROUP BY DATE_FORMAT(tbl_date.date, '%b') ORDER BY DATE(tbl_date.date);";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}