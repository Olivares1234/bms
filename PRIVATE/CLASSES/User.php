<?php
	
	class User {
		public $user_id;
		public $first_name;
		public $last_name;
		public $middle_name;
		public $contact_no;
		public $birth_date;
		public $email_address;
		public $sex;
		public $address;
		public $is_employed;
		public $barangay_id;
		public $username;
		public $password;
		public $user_type_id;
		public $date_added;
		public $default_password;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveOverAllUser() {
			$sql="SELECT * FROM tbl_user ORDER BY user_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function retrieveAllUser($user_id) {
			$sql="SELECT * FROM tbl_user WHERE user_id != :user_id ORDER BY user_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":user_id" => $user_id
			]);

			return $stmt->fetchAll();
		}

		public function getActiveUser() {
			$sql="SELECT * FROM tbl_user INNER JOIN tbl_barangay ON tbl_barangay.barangay_id = tbl_user.barangay_id WHERE (username = :username)";

			$stmt = $this->connection->prepare($sql);


			$stmt->execute([
				":username" => $this->username

			]);



			if($stmt->rowCount() <= 0) {
				return false;
			}
			else {

				$data = $stmt->fetch();
				$user = [];

				$is_correct_password = password_verify($this->password, $data['password']);
				
				if($is_correct_password) {


					$_SESSION['username'] = $data['username'];
					$_SESSION['user_id'] = $data['user_id'];
					$_SESSION['first_name'] = $data['first_name'];
					$_SESSION['last_name'] = $data['last_name'];
					$_SESSION['user_type_id'] = $data['user_type_id'];
					$_SESSION['barangay_id'] =  $data['barangay_id'];
					$_SESSION['barangay_name'] =  $data['barangay_name'];

					array_push($user, (object)[
						'barangay_id' => $_SESSION['barangay_id'],
						'user_type_id' => $_SESSION['user_type_id'],
						'is_employed' => $data['is_employed']
					]);
 
					echo json_encode($user);
				} else {
					echo json_encode(["message" => "incorrect password"]);
				}		
			}
		}

		public function retrieveUser($user_id, $barangay_id) {
			$sql = "SELECT * FROM `tbl_user` WHERE (user_id != :user_id AND barangay_id = :barangay_id) ORDER BY user_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":user_id" => $user_id,
				":barangay_id" => $barangay_id
			]);

			return $stmt->fetchAll();
		}

		public function getBarangayUser() {
			$sql="SELECT * FROM tbl_user WHERE barangay_id = $_SESSION[barangay_id]";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addUser(){
			$sql = "INSERT INTO `tbl_user`(`user_id`, `username`, `password`, `first_name`, `last_name`, `middle_name`, `contact_no`, `birth_date`, `email_address`, `sex`, `address`, `is_employed`, `barangay_id`, `user_type_id`, `default_password`, `date_added`)";
			$sql .= "VALUES (0,:username, :password, :first_name, :last_name, :middle_name, :contact_no, :birth_date, :email_address, :sex, :address, :is_employed, :barangay_id, :user_type_id, :default_password, :date_added)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":username" => $this->username,
				":password" => password_hash($this->password,PASSWORD_DEFAULT),
				":first_name" => $this->first_name,
				":last_name" => $this->last_name,
				":middle_name" => $this->middle_name,
				":contact_no" => $this->contact_no,
				":birth_date" => $this->birth_date,
				":email_address" => $this->email_address,
				":sex" => $this->sex,
				":address" => $this->address,
				":is_employed" => $this->is_employed,
				":barangay_id" => $this->barangay_id,
				":user_type_id" => $this->user_type_id,
				":default_password" => $this->default_password,
				":date_added" => $this->date_added

			]);
		}

		public function updateUser($new_password) {
			if($new_password == "") {
				$sql = "UPDATE tbl_user SET user_id = :user_id, username= :username, password= :password, first_name = :first_name, last_name = :last_name, middle_name = :middle_name, contact_no = :contact_no, birth_date = :birth_date, email_address = :email_address, sex = :sex, address = :address, is_employed = :is_employed, barangay_id = :barangay_id, user_type_id = :user_type_id WHERE user_id = :user_id";

				$stmt = $this->connection->prepare($sql);

				return $stmt->execute([
					":user_id" => $this->user_id,
					":username" => $this->username,
					":password" => $this->password,
					":first_name" => $this->first_name,
					":last_name" => $this->last_name,
					":middle_name" => $this->middle_name,
					":contact_no" => $this->contact_no,
					":birth_date" => $this->birth_date,
					":email_address" => $this->email_address,
					":sex" => $this->sex,
					":address" => $this->address,
					":is_employed" => $this->is_employed,
					":barangay_id" => $this->barangay_id,
					":user_type_id" => $this->user_type_id
				]);
			}
			else {
				$sql = "UPDATE tbl_user SET user_id = :user_id, username= :username, password= :password, first_name = :first_name, last_name = :last_name, middle_name = :middle_name, contact_no = :contact_no, birth_date = :birth_date, email_address = :email_address, sex = :sex, address = :address, is_employed = :is_employed, barangay_id = :barangay_id, user_type_id = :user_type_id WHERE user_id = :user_id";

				$stmt = $this->connection->prepare($sql);

				return $stmt->execute([
					":user_id" => $this->user_id,
					":username" => $this->username,
					":password" => password_hash($this->password,PASSWORD_DEFAULT),
					":first_name" => $this->first_name,
					":last_name" => $this->last_name,
					":middle_name" => $this->middle_name,
					":contact_no" => $this->contact_no,
					":birth_date" => $this->birth_date,
					":email_address" => $this->email_address,
					":sex" => $this->sex,
					":address" => $this->address,
					":is_employed" => $this->is_employed,
					":barangay_id" => $this->barangay_id,
					":user_type_id" => $this->user_type_id
				]);
			}
		}

		public function resetAccount($user_id) {
			$sql = "UPDATE `tbl_user` SET `password` = :password WHERE `tbl_user`.`user_id` = :user_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":user_id" => $user_id,
				":password" => password_hash($this->password,PASSWORD_DEFAULT)
			]);
		}

		public function deactivateUser($user_id) {
			$sql = "UPDATE `tbl_user` SET `is_employed` = '0' WHERE `tbl_user`.`user_id` = :user_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":user_id" => $user_id,
			]);
		}

		public function activateUser($user_id) {
			$sql = "UPDATE `tbl_user` SET `is_employed` = '1' WHERE `tbl_user`.`user_id` = :user_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":user_id" => $user_id,
			]);
		}

		public function assignUserAccount() {
			$sql="UPDATE `tbl_user` SET `barangay_id` = :barangay_id, `user_type_id` = :user_type_id WHERE `tbl_user`.`user_id` = :user_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":user_id" => $this->user_id,
				":barangay_id" => $this->barangay_id,
				":user_type_id" => $this->user_type_id
			]);
		}

		public function searchUser($filter, $keyword) {
			$sql="SELECT * FROM tbl_user WHERE user_id != $_SESSION[user_id] AND 
				CASE
					WHEN :filter = 'username' THEN (username LIKE :keyword)
					WHEN :filter = 'name' THEN (first_name LIKE :keyword OR middle_name LIKE :keyword OR last_name LIKE :keyword)
					WHEN :filter = 'status' THEN (is_employed LIKE :keyword)
				END
				ORDER BY user_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}

		public function searchAllUser($filter, $keyword) {
			$sql="SELECT * FROM tbl_user WHERE user_id != $_SESSION[user_id] AND 
				CASE
					WHEN :filter = 'username' THEN (username LIKE :keyword)
					WHEN :filter = 'name' THEN (first_name LIKE :keyword OR middle_name LIKE :keyword OR last_name LIKE :keyword)
					WHEN :filter = 'status' THEN (is_employed LIKE :keyword)
				END
				ORDER BY user_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":filter" => $filter,
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
	}