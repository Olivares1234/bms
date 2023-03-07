<?php

	class Purchase_Received_Details {
		public $purchase_received_details_id;
		public $purchase_received_id;
		public $purchase_order_id;
		public $supplier_medicine_id;
		public $received_quantity;
		public $expiration_date;
		public $status;
		public $barcode;


		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveCityHallMedicineList() {
			$sql="SELECT * FROM `tbl_purchase_received_details`  ORDER BY purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function searchCityHallAvailableMedicine($filter, $keyword) {
			$sql="SELECT tbl_purchase_received_details.purchase_received_details_id, tbl_purchase_received_details.purchase_received_id, tbl_purchase_received_details.supplier_medicine_id, SUM(tbl_purchase_received_details.received_quantity) AS received_quantity, tbl_purchase_received_details.expiration_date, tbl_purchase_received_details.status, tbl_supplier_medicine.supplier_medicine_id, tbl_supplier_medicine.supplier_medicine_id, tbl_category.description, tbl_unit_category.unit FROM `tbl_purchase_received_details` INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE NOW() < expiration_date AND (status = 'Active' AND received_quantity != 0) AND
			(";
				switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
			     }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => "%" . $keyword . "%"

			]);

			return $stmt->fetchAll();
		}

		public function searchCityHallUnavailableMedicine($filter, $keyword) {
			$sql="SELECT tbl_purchase_received_details.purchase_received_details_id, tbl_purchase_received_details.purchase_received_id, tbl_purchase_received_details.supplier_medicine_id, SUM(tbl_purchase_received_details.received_quantity) AS received_quantity, tbl_purchase_received_details.expiration_date, tbl_purchase_received_details.status, tbl_supplier_medicine.supplier_medicine_id, tbl_supplier_medicine.supplier_medicine_id, tbl_category.description, tbl_unit_category.unit FROM `tbl_purchase_received_details` INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE NOW() < expiration_date AND (status = 'Active' AND received_quantity = 0) AND
			(";
				switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
			     }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => "%" . $keyword . "%"

			]);

			return $stmt->fetchAll();
		}

		public function searchCityHallExpiredMedicine($filter, $keyword) {
			$sql="SELECT tbl_purchase_received_details.purchase_received_details_id, tbl_purchase_received_details.purchase_received_id, tbl_purchase_received_details.supplier_medicine_id, SUM(tbl_purchase_received_details.received_quantity) AS received_quantity, tbl_purchase_received_details.expiration_date, tbl_purchase_received_details.status, tbl_supplier_medicine.supplier_medicine_id, tbl_supplier_medicine.supplier_medicine_id, tbl_category.description, tbl_unit_category.unit FROM `tbl_purchase_received_details` INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE NOW() >= expiration_date AND (status = 'Active' AND received_quantity != 0) AND
			(";
				switch($filter){
		            case 'name':
		                $sql .= "tbl_supplier_medicine.medicine_name LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
		            case 'category':
		                $sql .= "tbl_category.description LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
		            case 'unit':
		                $sql .= "tbl_unit_category.unit LIKE :keyword)
		                GROUP BY tbl_supplier_medicine.supplier_medicine_id ORDER BY purchase_received_details_id";
		              		break;
			     }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => "%" . $keyword . "%"

			]);

			return $stmt->fetchAll();
		}

		public function searchCityHallMedicineForReferral($barcode) {
			$sql="SELECT `purchase_received_details_id`, `purchase_received_id`, `supplier_medicine_id`, `received_quantity`, `expiration_date`, `status` FROM `tbl_purchase_received_details` WHERE NOW() < expiration_date AND (status = 'Active' AND received_quantity != 0) AND barcode LIKE :barcode ORDER BY purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barcode" => "%" . $barcode . "%"

			]);

			return $stmt->fetchAll();
		}
 
		public function retrieveCityHallAvailableMedicine() {
			$sql="SELECT `purchase_received_details_id`, `purchase_received_id`, `supplier_medicine_id`, SUM(`received_quantity`) AS received_quantity, `expiration_date`, `status` FROM `tbl_purchase_received_details` WHERE NOW() < expiration_date AND (status = 'Active' AND received_quantity != 0) GROUP BY supplier_medicine_id ORDER BY purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveCityHallUnavailableMedicine() {
			$sql="SELECT `purchase_received_details_id`, `purchase_received_id`, `supplier_medicine_id`, SUM(`received_quantity`) AS received_quantity, `expiration_date`, `status` FROM `tbl_purchase_received_details` WHERE status = 'Not Active' OR received_quantity = 0 GROUP BY supplier_medicine_id ORDER BY purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveCityHallExpiredMedicine() {
			$sql="SELECT `purchase_received_details_id`, `purchase_received_id`, `supplier_medicine_id`, SUM(`received_quantity`) AS received_quantity, `expiration_date`, `status` FROM `tbl_purchase_received_details` WHERE NOW() > expiration_date GROUP BY supplier_medicine_id ORDER BY purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
 
		public function addPurchaseReceivedDetails() {
			$sql="INSERT INTO `tbl_purchase_received_details`(`purchase_received_details_id`, `purchase_received_id`, `supplier_medicine_id`, `received_quantity`, `expiration_date`, `status`, `barcode`) VALUES (0, :purchase_received_id, :supplier_medicine_id, :received_quantity, :expiration_date, :status, :barcode)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":purchase_received_id" => $this->purchase_received_id,
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":received_quantity" => $this->received_quantity,
				":expiration_date" => $this->expiration_date,
				":status" => $this->status,
				":barcode" => $this->barcode
			]);
		}

		public function updatePurchaseReceivedDetails() {
			$sql="UPDATE `tbl_purchase_received_details` SET `received_quantity` = :received_quantity WHERE `tbl_purchase_received_details`.`purchase_received_details_id` = :purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":received_quantity" => $this->received_quantity
			]);
			
		}

		public function searchPurchaseOrder($purchase_order_id) {
			$sql="SELECT tbl_supplier_medicine.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.category_id, tbl_category.description, tbl_unit_category.unit_category_id, tbl_unit_category.unit, tbl_purchase_order_details.quantity, tbl_purchase_order_details.price FROM tbl_purchase_order_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_order_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_purchase_order_details.purchase_order_id = :purchase_order_id ORDER BY tbl_purchase_order_details.purchase_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":purchase_order_id" => $purchase_order_id
			]);

			return $stmt->fetchAll();
		}

		public function retrievePurchaseReceivedDetails($purchase_order_id, $supplier_medicine_id) {
			$sql="SELECT tbl_purchase_received_details.purchase_received_details_id, tbl_purchase_received_details.purchase_received_id, tbl_purchase_received_details.supplier_medicine_id, tbl_purchase_received_details.received_quantity, tbl_purchase_received_details.expiration_date, tbl_purchase_received.user_id, tbl_user.first_name, tbl_user.last_name, tbl_purchase_received.date_received FROM tbl_purchase_received_details INNER JOIN tbl_purchase_received ON tbl_purchase_received.purchase_received_id = tbl_purchase_received_details.purchase_received_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_purchase_received.user_id WHERE tbl_purchase_received.purchase_order_id = :purchase_order_id AND tbl_purchase_received_details.supplier_medicine_id = :supplier_medicine_id ORDER BY tbl_purchase_received_details.purchase_received_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":purchase_order_id" => $purchase_order_id,
				":supplier_medicine_id" => $supplier_medicine_id
			]);

			return $stmt->fetchAll();
		}

		public function getPurchaseReceivedReports($search) {
			$sql="WITH orders AS (SELECT DATE_FORMAT(tbl_date.date, '%b %d') AS Date_Received, DATE(tbl_date.date) as month_num,
				tbl_purchase_received.purchase_received_id AS Total_Order, COALESCE(tbl_supplier.supplier_name, 'Null') AS Supplier,
				(tbl_purchase_received_details.received_quantity + COALESCE(SUM(tbl_send_order_details.quantity),0)) AS Quantity 

				FROM (tbl_date 
				LEFT JOIN 
					tbl_purchase_received ON tbl_purchase_received.date_received = tbl_date.date)
				LEFT JOIN 
					tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_id = tbl_purchase_received.purchase_received_id
				LEFT JOIN 
					tbl_send_order_details ON tbl_send_order_details.purchase_received_details_id = tbl_purchase_received_details.purchase_received_details_id 
				LEFT JOIN 
				    tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id 
				LEFT JOIN 
				    tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id 
				WHERE CASE
					WHEN :search = 'lifetime' THEN (tbl_date.date between  DATE_FORMAT(NOW() ,'%M-%d-01') AND NOW())
					WHEN :search = 'last_week' THEN (YEAR(tbl_date.date) = YEAR(NOW())
						AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) - 1)
					WHEN :search = 'this_week' THEN (YEAR(tbl_date.date) = YEAR(NOW())
						AND WEEKOFYEAR(tbl_date.date) = WEEKOFYEAR(NOW()) AND tbl_date.date <= now())
					WHEN :search = 'last_month' THEN (YEAR(tbl_date.date) = YEAR(NOW())
						AND MONTH(tbl_date.date) = MONTH(NOW()) - 1)
					WHEN :search = 'this_month' THEN (date between  DATE_FORMAT(NOW() ,'%Y-%m-01') 
						AND NOW() AND tbl_date.date <= now())
					WHEN :search = 'this_year' THEN (YEAR(tbl_date.date) = YEAR(NOW()) AND tbl_date.date <= now())
					WHEN :search = 'last_year' THEN (YEAR(tbl_date.date) = YEAR(NOW()) - 1)
				END
				GROUP BY tbl_purchase_received.purchase_received_id, month_num)
				SELECT 
				    Date_Received,
				    COALESCE(SUM(Quantity),0) AS Quantity, 
				    COALESCE(COUNT(Total_Order),0) AS Total_Order,
				    Supplier
				from orders 
				GROUP BY Date_Received, month_num
				ORDER BY month_num";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":search" => $search
			]);

			return $stmt->fetchAll();
		}

		public function getTotalPurchaseReceived() {
			$sql="WITH orders AS (
				    SELECT
				        YEAR(tbl_date.date) AS Year,
				        DATE_FORMAT(tbl_date.date, '%b') AS Month,
				        MONTH(tbl_date.date) as month_num,
				        COUNT(tbl_purchase_received_details.purchase_received_id) AS Total_Order, 
				        SUM(IFNULL(tbl_purchase_received_details.received_quantity,0)) AS Quantity, 
				        IFNULL(tbl_supplier_medicine.price,0) AS Price, 
				        IFNULL((tbl_supplier_medicine.price) * 
				        SUM(tbl_purchase_received_details.received_quantity),0) AS Total_Amount, 
				        tbl_supplier.supplier_name AS Supplier 
				    FROM tbl_date 
				    LEFT JOIN tbl_purchase_received
				        ON tbl_purchase_received.date_received = tbl_date.date 
				    LEFT JOIN tbl_purchase_received_details
				        ON tbl_purchase_received.purchase_received_id = tbl_purchase_received_details.purchase_received_id 
				    LEFT JOIN tbl_supplier_medicine
				        ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id 
				    LEFT JOIN tbl_supplier
				        ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id 
				    WHERE YEAR(tbl_date.date) = YEAR(NOW())
				    GROUP BY Month, month_num, tbl_supplier_medicine.supplier_medicine_id
				)
				SELECT 
				    Month,
				    COALESCE(SUM(Quantity),0) AS Quantity, 
				    COALESCE(SUM(Total_Amount),0) AS Total_Amount
				from orders 
				GROUP BY Month, month_num
				ORDER BY month_num";

				$stmt = $this->connection->prepare($sql);

				$stmt->execute();

				return $stmt->fetchAll();
		}
	}