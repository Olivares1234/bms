<?php
	
	class Category {
		// for city hall property
		public $category_id;
		public $description;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		// city hall method
		public function getAllCategory() {
			$sql = "SELECT * FROM tbl_category ORDER BY category_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addCategory() {

			$sql = "INSERT INTO `tbl_category`(`category_id`, `description`)";
			$sql .= "VALUES (0, :description)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":description" => $this->description
			]);
		}

		public function updateCategory() {
			$sql = "UPDATE tbl_category SET category_id = :category_id, description = :description WHERE category_id = :category_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":category_id" => $this->category_id,
				":description" => $this->description
			]);
		}

		public function searchCategory($keyword) {
			$sql = "SELECT * FROM tbl_category WHERE description LIKE :keyword";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}

		//end city hall method
	}