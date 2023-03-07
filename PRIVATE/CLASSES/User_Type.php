<?php
	
	class User_Type {
		public $user_type_id;
		public $description;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveUserType() {
			$sql = "SELECT * FROM `user_type` ORDER BY user_type_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}
	}