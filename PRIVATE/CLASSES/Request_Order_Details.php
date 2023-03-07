<?php

	class Request_Order_Details {
		public $request_order_details_id;
		public $request_order_id;
		public $purchase_received_details_id;
		
		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function addRequestOrderDetails() {
			$sql="INSERT INTO `tbl_request_order_details`(`request_order_details_id`, `request_order_id`, `purchase_received_details_id`) VALUES (0, :request_order_id, :purchase_received_details_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":request_order_id" => $this->request_order_id,
				":purchase_received_details_id" => $this->purchase_received_details_id
			]);
		}

		public function retrieveBarangayRequestOrderDetails($request_order_id) {
			$sql="SELECT tbl_request_order_details.request_order_id, tbl_request_order_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_supplier_medicine.price FROM tbl_request_order_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_request_order_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_request_order_details.request_order_id = :request_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":request_order_id" => $request_order_id
			]);

			return $stmt->fetchAll();
		}

		public function searchRequestOrderDetails($keyword) {
			$sql="SELECT tbl_request_order_details.request_order_id, tbl_request_order_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_supplier_medicine.price, tbl_request_details.delivered_quantity FROM tbl_request_order_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_request_order_details.supplier_medicine_id INNER JOIN tbl_request_details ON tbl_request_details.supplier_medicine_id = tbl_request_order_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_supplier_medicine.medicine_name LIKE :keyword OR tbl_category.description LIKE :keyword OR tbl_unit_category.unit LIKE :keyword OR tbl_supplier_medicine.price LIKE :keyword ORDER BY tbl_request_order_details.request_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => "%" . $keyword . "%"
			]);

			return $stmt->fetchAll();
		}

		public function getRequestReports($search) {
			$sql="SELECT DATE_FORMAT(tbl_date.date, '%b %d') AS Date_Request, COUNT(tbl_request_order_details.request_order_id) AS Total_Order, CASE WHEN tbl_supplier.supplier_name is NULL THEN 'Null' ELSE 'City Hall' END AS Supplier 
			FROM (tbl_date 

			LEFT JOIN tbl_request_order ON tbl_request_order.date_request = tbl_date.date AND tbl_request_order.barangay_id = 1)

			LEFT JOIN tbl_request_order_details ON tbl_request_order.request_order_id = tbl_request_order_details.request_order_id

			LEFT JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_request_order_details.purchase_received_details_id

			LEFT JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id 

			LEFT JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id 
			
			LEFT JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_request_order.barangay_id WHERE

				(";
		        switch($search){
		            case 'lifetime':
		                $sql .= "(tbl_date.date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW())) GROUP BY tbl_date.date
		                	ORDER BY tbl_date.date;";
		              		break;
		            case 'last_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
				AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) - 1) 
		                	GROUP BY tbl_date.date
		                	ORDER BY tbl_date.date;";
		              		break;
		            case 'this_week':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
				AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) AND tbl_date.date <= now())
		                	GROUP BY tbl_date.date
		                	ORDER BY tbl_date.date;";
		              		break;
		            case 'last_month':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
				AND MONTH(tbl_date.date) = MONTH(NOW()) - 1) 
		                	GROUP BY tbl_date.date
							ORDER BY tbl_date.date;";
		              		break;
		            case 'this_month':
		                $sql .= "YEAR(tbl_date.date) = YEAR(NOW())
				AND MONTH(tbl_date.date) = MONTH(NOW()) AND tbl_date.date <= now()) 
		                	GROUP BY tbl_date.date
							ORDER BY tbl_date.date;";
		              		break;
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