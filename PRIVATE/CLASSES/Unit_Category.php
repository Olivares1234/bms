<?php
	
	class Unit_Category {
		public $unit_category_id;
		public $description;
		public $unit;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function getAllUnitCategory() {
			$sql = "SELECT * FROM tbl_unit_category ORDER BY unit_category_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addUnitCategory() {
			$sql = "INSERT INTO `tbl_unit_category`(`unit_category_id`, `unit`)";
			$sql .= "VALUES (0, :unit)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":unit" => $this->unit
			]);
		}

		public function updateUnitCategory() {
			$sql = "UPDATE tbl_unit_category SET unit_category_id = :unit_category_id, unit = :unit WHERE unit_category_id = :unit_category_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":unit_category_id" => $this->unit_category_id,
				":unit" => $this->unit
			]);
		}

		public function searchUnitCategory($keyword) {
			$sql = "SELECT * FROM tbl_unit_category WHERE unit LIKE :keyword";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}

	}