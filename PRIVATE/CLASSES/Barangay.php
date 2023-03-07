<?php

	class Barangay {
		public $barangay_name;
		public $barangay_id;
		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function getAllBarangay() {
			$sql = "SELECT * FROM tbl_barangay";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function getBarangayInventory($barangay_id) {
			$sql = "SELECT tbl_medicine.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_supplier_medicine.category_id, tbl_category.description, tbl_supplier_medicine.unit_category_id, tbl_unit_category.unit, tbl_supplier_medicine.price, tbl_medicine.quantity, tbl_barangay.barangay_id, tbl_barangay.barangay_name FROM tbl_barangay INNER JOIN tbl_medicine ON tbl_medicine.barangay_id = tbl_barangay.barangay_id INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_medicine.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_barangay.barangay_id = :barangay_id AND tbl_medicine.status = 'Active' ORDER BY tbl_medicine.medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}
	}