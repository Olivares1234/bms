<?php

	class Supplier_Medicine {
		public $supplier_medicine_id;
		public $medicine_name;
		public $category_id;
		public $unit_category_id;
		public $price;
		public $supplier_id;

		public $keyword;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function getAllSupplierMedicine($supplier_id) {
			$sql = "SELECT * FROM tbl_supplier_medicine WHERE supplier_id = :supplier_id ORDER BY supplier_medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":supplier_id" => $supplier_id
			]);

			return $stmt->fetchAll();
		}

		public function addSupplierMedicine() {
			$sql = "INSERT INTO `tbl_supplier_medicine` (`supplier_medicine_id`, `medicine_name`, `category_id`, `unit_category_id`, `price`, `supplier_id`) VALUES (0, :medicine_name, :category_id, :unit_category_id, :price, :supplier_id)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":medicine_name" => $this->medicine_name,
				":category_id" => $this->category_id,
				":unit_category_id" => $this->unit_category_id,
				":price" => $this->price,
				":supplier_id" => $this->supplier_id
			]);
		}

		public function updateSupplierMedicine() {
			$sql = "UPDATE `tbl_supplier_medicine` SET `supplier_medicine_id`= :supplier_medicine_id,`medicine_name`= :medicine_name,`category_id`= :category_id,`unit_category_id`= :unit_category_id, `price` = :price, `supplier_id`= :supplier_id WHERE supplier_medicine_id = :supplier_medicine_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":supplier_medicine_id" => $this->supplier_medicine_id,
				":medicine_name" => $this->medicine_name,
				":category_id" => $this->category_id,
				":unit_category_id" => $this->unit_category_id,
				":price" => $this->price,
				":supplier_id" => $this->supplier_id
			]);
		}

		public function searchSupplierMedicine($supplier_id, $keyword) {
			$sql = "SELECT tbl_supplier_medicine.supplier_medicine_id, tbl_supplier_medicine.medicine_name,  tbl_supplier_medicine.category_id, tbl_category.description,  tbl_supplier_medicine.unit_category_id, tbl_unit_category.unit, tbl_supplier_medicine.price FROM tbl_supplier_medicine INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id INNER JOIN tbl_supplier ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id WHERE (tbl_supplier_medicine.supplier_id = :supplier_id) AND (tbl_supplier_medicine.medicine_name LIKE :keyword OR tbl_category.description LIKE :keyword OR tbl_unit_category.unit LIKE :keyword) ORDER BY tbl_supplier_medicine.supplier_medicine_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":supplier_id" => $supplier_id,
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}

		public function retrieveSupplierMedicine() {
			$sql = "SELECT * FROM `tbl_supplier_medicine` ORDER BY supplier_medicine_id";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}