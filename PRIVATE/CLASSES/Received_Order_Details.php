<?php

	class Received_Order_Details {
		public $received_order_details_id;
		public $received_order_id;
		public $purchase_received_details_id;
		public $quantity;
		public $price;
		public $expiration_date;
		public $total_amount;
		public $barcode;
		public $status;

		public $send_order_id;

		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveAllReceivedOrderDetails() {
			$sql="SELECT * FROM tbl_received_order_details ORDER BY received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveOutOfStockMedicine($barangay_id) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE (tbl_received_order_details.quantity = 0 AND tbl_received_order.barangay_id = :barangay_id) GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();
		}

		public function retrieveReceivedOrderDetails($send_order_id, $purchase_received_details_id, $barangay_id) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, tbl_received_order_details.quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_received_order.send_order_id, tbl_received_order.user_id, tbl_received_order.date_received, tbl_received_order.barangay_id, tbl_user.first_name, tbl_user.last_name FROM tbl_received_order_details INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_received_order.user_id WHERE tbl_received_order.send_order_id = :send_order_id AND tbl_received_order_details.purchase_received_details_id = :purchase_received_details_id AND tbl_received_order.barangay_id = :barangay_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":send_order_id" => $send_order_id,
				":purchase_received_details_id" => $purchase_received_details_id,
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function medicineDetails($supplier_medicine_id, $barangay_id) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, tbl_received_order_details.quantity, tbl_received_order_details.expiration_date, tbl_purchase_received_details.purchase_received_details_id, tbl_purchase_received_details.supplier_medicine_id FROM tbl_received_order_details INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id WHERE tbl_purchase_received_details.supplier_medicine_id = :supplier_medicine_id AND tbl_received_order.barangay_id = :barangay_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":supplier_medicine_id" => $supplier_medicine_id

			]);

			return $stmt->fetchAll();
		}

		public function medicinePerBarangay($filter, $barangay_id) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_supplier_medicine.price, tbl_barangay.barangay_name FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_received_order.barangay_id WHERE 

			(";
		        switch($filter){
		            case 'available':
		                $sql .= "(NOW() < tbl_received_order_details.expiration_date AND tbl_received_order_details.status = 'Active' AND tbl_received_order_details.quantity != 0 AND tbl_received_order.barangay_id = :barangay_id)) GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id;";
		              		break;
		            case 'unavailable':
		                $sql .= "(tbl_received_order_details.status = 'Not Active' AND tbl_received_order.barangay_id = :barangay_id) OR (tbl_received_order_details.quantity = 0 AND tbl_received_order.barangay_id = :barangay_id)) GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id;";
		              		break;
		            case 'expired':
		                $sql .= "(NOW() > tbl_received_order_details.expiration_date AND tbl_received_order.barangay_id = :barangay_id)) GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id;";
		              		break;
			    }
		    ")";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();
		}

		public function searchAvailableMedicine($barangay_id, $keyword, $filter) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE (NOW() < tbl_received_order_details.expiration_date AND tbl_received_order_details.status = 'Active' AND tbl_received_order_details.quantity != 0 AND tbl_received_order.barangay_id = :barangay_id) AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":filter" => $filter,
				":keyword" => "%" . $keyword . "%"

			]);

			return $stmt->fetchAll();
		}

		public function availableMedicine($barangay_id) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE (NOW() < tbl_received_order_details.expiration_date AND tbl_received_order_details.status = 'Active' AND tbl_received_order_details.quantity != 0 AND tbl_received_order.barangay_id = :barangay_id) GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();
		}

		public function searchExpiredMedicine($barangay_id, $keyword, $filter) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE (NOW() > tbl_received_order_details.expiration_date AND tbl_received_order.barangay_id = :barangay_id) AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":filter" => $filter,
				":keyword" => "%" . $keyword . "%"

			]);

			return $stmt->fetchAll();
		}

		public function expiredMedicine($barangay_id) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE (NOW() > tbl_received_order_details.expiration_date AND tbl_received_order.barangay_id = :barangay_id) GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();
		}

		public function searchUnavailableMedicine($barangay_id, $keyword, $filter) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE ( tbl_received_order_details.status = 'Not Active' OR tbl_received_order_details.quantity = 0 AND tbl_received_order.barangay_id = :barangay_id) AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":filter" => $filter,
				":keyword" => "%" . $keyword . "%"

			]);

			return $stmt->fetchAll();
		}

		public function unavailableMedicine($barangay_id) {
			$sql="SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.purchase_received_details_id, SUM(tbl_received_order_details.quantity) as quantity, tbl_received_order_details.expiration_date, tbl_received_order_details.status, tbl_received_order_details.barcode, tbl_purchase_received_details.supplier_medicine_id FROM tbl_received_order_details INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id  INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE ( tbl_received_order_details.status = 'Not Active' OR tbl_received_order_details.quantity = 0 AND tbl_received_order.barangay_id = :barangay_id) GROUP BY tbl_purchase_received_details.supplier_medicine_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();

		}

		public function retrieveAvailableMedicine($barangay_id) {
			$sql = "SELECT * FROM `tbl_received_order_details` INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE (NOW() < expiration_date AND status = 'Active' AND quantity != 0 AND barangay_id = :barangay_id) ORDER BY `received_order_details_id`";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();
		}

		public function searchAvailableMedicineForTransaction($barangay_id, $barcode) {
			$sql = "SELECT * FROM `tbl_received_order_details` INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE (NOW() < expiration_date AND status = 'Active' AND quantity != 0 AND barangay_id = :barangay_id) AND barcode LIKE :barcode ORDER BY `received_order_details_id`";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
				":barcode" => "%" . $barcode . "%"

			]);

			return $stmt->fetchAll();
		}

		public function retrieveUnavailableMedicine($barangay_id) {
			$sql = "SELECT * FROM `tbl_received_order_details` INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE (status = 'Not Active' OR quantity = 0 AND barangay_id = :barangay_id) ORDER BY `received_order_details_id`";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();
		}
		public function retrieveExpiredMedicine($barangay_id) {
			$sql = "SELECT * FROM `tbl_received_order_details` INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE (NOW() >= expiration_date AND barangay_id = :barangay_id) ORDER BY `received_order_details_id`";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,

			]);

			return $stmt->fetchAll();
		}

		public function retrieveBarangayReceivedOrderDetails($barangay_id) {
			$sql = "SELECT * FROM tbl_received_order_details INNER JOIN tbl_received_order ON tbl_received_order.received_order_id = tbl_received_order_details.received_order_id WHERE tbl_received_order.barangay_id = :barangay_id ORDER BY tbl_received_order_details.received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id,
			]);

			return $stmt->fetchAll();
		}

		public function getExpiredMedicine() {
			$sql = "SELECT tbl_received_order_details.received_order_details_id, tbl_received_order_details.received_order_id, tbl_received_order_details.medicine_id, SUM(tbl_received_order_details.quantity) AS quantity, tbl_medicine.medicine_name, tbl_received_order_details.price, tbl_received_order_details.expiration_date, tbl_received_order_details.total_amount, tbl_received_order_details.is_updated FROM `tbl_received_order_details` INNER JOIN tbl_medicine ON tbl_medicine.medicine_id = tbl_received_order_details.medicine_id WHERE tbl_received_order_details.expiration_date <= CURRENT_DATE() AND tbl_received_order_details.is_updated = 'No' GROUP BY tbl_received_order_details.medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function updateReceivedOrderDetails() {
			$sql="UPDATE `tbl_received_order_details` SET `quantity` = :quantity WHERE `tbl_received_order_details`.`received_order_details_id` = :received_order_details_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":received_order_details_id" => $this->received_order_details_id,

				":quantity" => $this->quantity,
			]);
		}

		public function addReceivedOrderDetails() {
			$sql="INSERT INTO `tbl_received_order_details`(`received_order_details_id`, `received_order_id`, `purchase_received_details_id`, `quantity`, `expiration_date`, `status`, `barcode`) VALUES (0, :received_order_id, :purchase_received_details_id, :quantity, :expiration_date, :status, :barcode)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":received_order_id" => $this->received_order_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":quantity" => $this->quantity,
				":expiration_date" => $this->expiration_date,
				":status" => $this->status,
				":barcode" => $this->barcode
			]);
		}

		public function getReceivedReports($search) {
			$sql="WITH orders AS (SELECT DATE_FORMAT(tbl_date.date, '%b %d') AS Date_Received, DATE(tbl_date.date) as month_num,
				tbl_received_order.received_order_id AS Total_Order, tbl_supplier.supplier_name AS Supplier,
				(tbl_received_order_details.quantity + COALESCE(SUM(tbl_transaction_details.quantity),0)) AS Quantity, tbl_supplier_medicine.price AS Total 

				FROM (tbl_date 
				LEFT JOIN 
					tbl_received_order ON tbl_received_order.date_received = tbl_date.date AND tbl_received_order.barangay_id = $_SESSION[barangay_id])
				LEFT JOIN 
					tbl_received_order_details ON tbl_received_order_details.received_order_id = tbl_received_order.received_order_id
				LEFT JOIN 
					tbl_transaction_details ON tbl_transaction_details.received_order_details_id = tbl_received_order_details.received_order_details_id 
				LEFT JOIN
				     tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
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
				GROUP BY tbl_received_order_details.received_order_details_id, month_num)
				SELECT 
				    Date_Received,
				    COALESCE(SUM(Quantity),0) AS Quantity, 
				    COALESCE(COUNT(Total_Order),0) AS Total_Order,
                    IFNULL(COALESCE(SUM(Quantity),0) * Total,0) AS Total,
				    CASE WHEN Supplier is NULL THEN 'Null' ELSE 'City Hall' END AS Supplier
				from orders 
				GROUP BY Date_Received, month_num
				ORDER BY month_num";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":search" => $search
			]);

			return $stmt->fetchAll();
		}

		public function getReceivedReportsYear() {
			$sql="WITH orders AS (SELECT DATE_FORMAT(tbl_date.date, '%b') AS Date_Received, MONTH(tbl_date.date) as month_num,
				tbl_received_order.received_order_id AS Total_Order, tbl_supplier.supplier_name AS Supplier,
				(tbl_received_order_details.quantity + COALESCE(SUM(tbl_transaction_details.quantity),0)) AS Quantity, tbl_supplier_medicine.price AS Total 

				FROM (tbl_date 
				LEFT JOIN 
					tbl_received_order ON tbl_received_order.date_received = tbl_date.date AND tbl_received_order.barangay_id = $_SESSION[barangay_id])
				LEFT JOIN 
					tbl_received_order_details ON tbl_received_order_details.received_order_id = tbl_received_order.received_order_id
				LEFT JOIN 
					tbl_transaction_details ON tbl_transaction_details.received_order_details_id = tbl_received_order_details.received_order_details_id 
				LEFT JOIN
				     tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_received_order_details.purchase_received_details_id
				LEFT JOIN 
				    tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_purchase_received_details.supplier_medicine_id 
				LEFT JOIN 
				    tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id
				WHERE YEAR(tbl_date.date) = YEAR(NOW())
				GROUP BY tbl_received_order_details.received_order_details_id, tbl_date.date)
				SELECT 
				    Date_Received,
				    COALESCE(SUM(Quantity),0) AS Quantity, 
				    COALESCE(COUNT(Total_Order),0) AS Total_Order,
                     COALESCE(SUM(Quantity),0) * Total AS Amount,
				    CASE WHEN Supplier is NULL THEN 'Null' ELSE 'City Hall' END AS Supplier
				from orders 
				GROUP BY Date_Received, month_num
				ORDER BY month_num";

		        $stmt = $this->connection->prepare($sql);

				$stmt->execute();

				return $stmt->fetchAll();
		}
	}
