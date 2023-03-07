<?php

	class Civil_Status {
		public $civil_status_id;
		public $description;



		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveCivilStatus() {
			$sql = "SELECT * FROM tbl_civil_status WHERE 1";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}