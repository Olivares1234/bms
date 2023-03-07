<?php

	class Database {
		public $host;
		public $user;
		public $password;
		public $name;

		private $connection;

		public function __construct(){
			$this->host = DB_HOST;
			$this->user = DB_USER;
			$this->password = DB_PASS;
			$this->name = DB_NAME;


			$dsn = 'mysql:host='. $this->host . ';dbname=' . $this->name;

			try {
				$this->connection = new PDO($dsn,$this->user,$this->password);
			} catch (PDOException $e) {
				die("an error occured" . $e->getMessage());
			}
		}

		public function getConnection() {
			return $this->connection;
		}
	}