<?php
	
	class Medicine {
		public $medicine_id;
		public $supplier_medicine_id;
		public $quantity;
		public $status;
		public $expiration_date;
		public $barangay_id;

		private $connection;



		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveMedicine($barangay_id) {
			$sql="SELECT * FROM tbl_medicine WHERE barangay_id = :barangay_id ORDER BY medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveAvailableMedicine($barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, (IFNULL(tbl_medicine.quantity - SUM(CASE WHEN NOW() > tbl_received_order_details.expiration_date THEN tbl_received_order_details.quantity ELSE 0 END),0)) - tbl_transaction_details.quantity AS quantity, tbl_medicine.status, tbl_medicine.barangay_id FROM tbl_medicine INNER JOIN tbl_received_order_details ON tbl_received_order_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_transaction_details ON tbl_transaction_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id WHERE tbl_medicine.status = 'Active' AND tbl_medicine.barangay_id = :barangay_id

				GROUP BY supplier_medicine_id HAVING quantity > '0' ORDER BY supplier_medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveCityHallAvailableMedicine($barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, (IFNULL(tbl_medicine.quantity 
				   - SUM(CASE WHEN NOW() > tbl_purchase_received_details.expiration_date 
				              THEN tbl_purchase_received_details.received_quantity 
				              ELSE 0 
				         END)
				  ,0)) AS Total FROM tbl_medicine INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id WHERE tbl_medicine.status = 'Active' AND tbl_medicine.barangay_id = :barangay_id
				GROUP BY supplier_medicine_id HAVING Total > 0 ORDER BY supplier_medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveUnavailableMedicine($barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, tbl_medicine.status, tbl_medicine.barangay_id, (IFNULL(tbl_medicine.quantity 
				   - SUM(CASE WHEN NOW() > tbl_received_order_details.expiration_date 
				              THEN tbl_received_order_details.quantity 
				              ELSE 0 
				         END)
				  ,0)) - tbl_transaction_details.quantity 
                  AS quantity, tbl_medicine.barangay_id FROM tbl_medicine INNER JOIN tbl_received_order_details ON tbl_received_order_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_transaction_details ON tbl_transaction_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id WHERE tbl_medicine.status = 'Not Active' OR  barangay_id = :barangay_id GROUP BY supplier_medicine_id HAVING quantity = 0 ORDER BY medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}
 
		public function retrieveExpiredMedicine($barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, SUM(tbl_received_order_details.quantity) AS Quantity, tbl_medicine.barangay_id AS Barangay, tbl_received_order_details.expiration_date FROM tbl_medicine INNER JOIN tbl_received_order_details ON tbl_received_order_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id WHERE DATE(NOW()) > tbl_received_order_details.expiration_date AND barangay_id = :barangay_id GROUP BY supplier_medicine_id HAVING Quantity > 0 ORDER BY medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveCityHallUnavailableMedicine($barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, (IFNULL(tbl_medicine.quantity 
				   - SUM(CASE WHEN NOW() > tbl_purchase_received_details.expiration_date 
				              THEN tbl_purchase_received_details.received_quantity 
				              ELSE 0 
				         END)
				  ,0)) AS Quantity, tbl_medicine.barangay_id AS Barangay FROM tbl_medicine INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id WHERE tbl_medicine.status = 'Active' AND barangay_id = :barangay_id GROUP BY supplier_medicine_id HAVING Quantity = 0 ORDER BY medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function retrieveCityHallExpiredMedicine($barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, SUM(tbl_purchase_received_details.received_quantity) AS Quantity, tbl_medicine.barangay_id AS Barangay, tbl_purchase_received_details.expiration_date FROM tbl_medicine INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id WHERE tbl_medicine.status = 'Active' AND DATE(NOW()) > tbl_purchase_received_details.expiration_date AND barangay_id = :barangay_id GROUP BY supplier_medicine_id HAVING Quantity > 0 ORDER BY medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function getAllMedicine() {
			$sql = "SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_supplier_medicine.category_id, tbl_category.description, tbl_supplier_medicine.unit_category_id, tbl_unit_category.unit, tbl_supplier_medicine.price, tbl_medicine.quantity, tbl_supplier_medicine.supplier_id, tbl_supplier.supplier_name, tbl_medicine.status, tbl_medicine.barangay_id FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE tbl_medicine.barangay_id = '19' AND tbl_medicine.quantity != 0 ORDER BY tbl_medicine.medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getAllUnavailableMedicine() {
			$sql = "SELECT tbl_medicine.medicine_id, tbl_medicine.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_supplier_medicine.category_id, tbl_category.description, tbl_supplier_medicine.unit_category_id, tbl_unit_category.unit, tbl_supplier_medicine.price, tbl_medicine.quantity, tbl_supplier_medicine.supplier_id, tbl_supplier.supplier_name, tbl_medicine.status, tbl_medicine.barangay_id FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE tbl_medicine.barangay_id = '19' AND (tbl_medicine.status = 'Not Active' OR tbl_medicine.quantity = 0) ORDER BY tbl_medicine.medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
		
		public function addMedicine() {
			$sql = "INSERT INTO `tbl_medicine`(`medicine_id`, `supplier_medicine_id`, `quantity`, `status`, `barangay_id`)";
			$sql .= "VALUES (0, :supplier_medicine_id, :quantity, :status, :barangay_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":quantity" => $this->quantity,
				":status" => $this->status,
				":barangay_id" => $this->barangay_id
			]);
		}

		public function updateMedicine() {
			$sql = "UPDATE `tbl_medicine` SET `medicine_id`= :medicine_id,`supplier_medicine_id`= :supplier_medicine_id,`quantity`= :quantity, `status` = :status, `barangay_id`= :barangay_id WHERE medicine_id = :medicine_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":medicine_id" => $this->medicine_id,
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":quantity" => $this->quantity,
				":status" => $this->status,
				":barangay_id" => $this->barangay_id
			]);
		}

		public function searchCityHallAvailableMedicine($filter, $keyword, $barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_supplier_medicine.medicine_name, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, tbl_category.description, tbl_unit_category.unit, (IFNULL(tbl_medicine.quantity 
				   - SUM(CASE WHEN NOW() > tbl_purchase_received_details.expiration_date 
				              THEN tbl_purchase_received_details.received_quantity 
				              ELSE 0 
				         END)
				  ,0)) AS Total FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id

				WHERE status = 'Active' AND barangay_id = :barangay_id AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY supplier_medicine_id HAVING Total > '0' ORDER BY supplier_medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function searchCityHallUnavailableMedicine($filter, $keyword, $barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_supplier_medicine.medicine_name, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, tbl_category.description, tbl_unit_category.unit, (IFNULL(tbl_medicine.quantity 
				   - SUM(CASE WHEN NOW() > tbl_purchase_received_details.expiration_date 
				              THEN tbl_purchase_received_details.received_quantity 
				              ELSE 0 
				         END)
				  ,0)) AS Quantity FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id

				WHERE status = 'Not Active' OR barangay_id = :barangay_id AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY supplier_medicine_id HAVING Quantity = '0' ORDER BY medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function searchCityHallExpiredMedicine($filter, $keyword, $barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_supplier_medicine.medicine_name, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, tbl_category.description, tbl_unit_category.unit, SUM(tbl_purchase_received_details.received_quantity) AS Quantity, tbl_purchase_received_details.expiration_date FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_purchase_received_details ON tbl_purchase_received_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id

				WHERE status = 'Active' AND DATE(NOW()) > tbl_purchase_received_details.expiration_date AND barangay_id = :barangay_id AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY supplier_medicine_id HAVING Quantity > 0 ORDER BY medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}









































		public function searchBarangayAvailableMedicine($filter, $keyword, $barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_supplier_medicine.medicine_name, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, tbl_category.description, tbl_unit_category.unit, (IFNULL(tbl_medicine.quantity 
				   - SUM(CASE WHEN NOW() > tbl_received_order_details.expiration_date 
				              THEN tbl_received_order_details.quantity 
				              ELSE 0 
				         END)
				  ,0)) AS Total FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_received_order_details ON tbl_received_order_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id 

				WHERE status = 'Active' AND barangay_id = :barangay_id AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY supplier_medicine_id HAVING Total > '0' ORDER BY supplier_medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function searchBarangayUnavailableMedicine($filter, $keyword, $barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_supplier_medicine.medicine_name, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, tbl_category.description, tbl_unit_category.unit, (IFNULL(tbl_medicine.quantity - SUM(tbl_received_order_details.quantity),0)) AS Quantity FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_received_order_details ON tbl_received_order_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id 

				WHERE (status = 'Not Active' OR barangay_id = :barangay_id) AND DATE(NOW()) > tbl_received_order_details.expiration_date AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY supplier_medicine_id HAVING Quantity = 0 ORDER BY medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function searchBarangayExpiredMedicine($filter, $keyword, $barangay_id) {
			$sql="SELECT tbl_medicine.medicine_id, tbl_supplier_medicine.medicine_name, tbl_medicine.supplier_medicine_id, tbl_medicine.quantity, tbl_medicine.status, tbl_medicine.barangay_id, tbl_category.description, tbl_unit_category.unit, tbl_received_order_details.expiration_date, SUM(tbl_received_order_details.quantity) AS Quantity FROM tbl_medicine INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_received_order_details ON tbl_received_order_details.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id 

				WHERE (status = 'Active' AND barangay_id = :barangay_id) AND DATE(NOW()) > tbl_received_order_details.expiration_date AND
				CASE
					WHEN :filter = 'medicine name' THEN (medicine_name LIKE :keyword)
					WHEN :filter = 'category' THEN (description LIKE :keyword)
					WHEN :filter = 'unit category' THEN (unit LIKE :keyword)
				END
				GROUP BY supplier_medicine_id HAVING Quantity > 0 ORDER BY medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%',
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}
		

	}