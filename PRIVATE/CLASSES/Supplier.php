<?php

	class Supplier {
		public $supplier_id;
		public $supplier_name;
		public $supplier_address;
		public $supplier_contact_no;
		public $supplier_status;

		private $connection;


		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveSupplier() {
			$sql = "SELECT * FROM tbl_supplier";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function addSupplier() {
			$sql = "INSERT INTO `tbl_supplier`(`supplier_id`, `supplier_name`, `supplier_address`, `supplier_contact_no`, `supplier_status`)";
			$sql .= "VALUES (0, :supplier_name, :supplier_address, :supplier_contact_no, :supplier_status)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":supplier_name" => $this->supplier_name,
				":supplier_address" => $this->supplier_address,
				":supplier_contact_no" => $this->supplier_contact_no,
				":supplier_status" => $this->supplier_status
			]);
		}

		public function updateSupplier() {
			$sql = "UPDATE tbl_supplier SET supplier_id = :supplier_id, supplier_name = :supplier_name, supplier_address = :supplier_address, supplier_contact_no = :supplier_contact_no, supplier_status = :supplier_status WHERE supplier_id = :supplier_id";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":supplier_id" => $this->supplier_id,
				":supplier_name" => $this->supplier_name,
				":supplier_address" => $this->supplier_address,
				":supplier_contact_no" => $this->supplier_contact_no,
				":supplier_status" => $this->supplier_status
			]);
		}

		// public function searchSupplier($keyword) {
		// 	$sql = "SELECT supplier_name, supplier_address, supplier_contact_no, supplier_status FROM tbl_supplier WHERE supplier_name LIKE :keyword OR supplier_address LIKE :keyword OR supplier_contact_no LIKE :keyword OR supplier_status LIKE :keyword ORDER BY tbl_supplier.supplier_id";
		// 	$stmt = $this->connection->prepare($sql);

		// 	$stmt->execute([
		// 		":keyword" => '%' . $keyword . '%'
		// 	]);

		// 	return $stmt->fetchAll();
		// }


		public function deactivateSupplier($supplier_id) {
			$sql = "UPDATE `tbl_supplier` SET `supplier_status` = 'Not Active' WHERE `tbl_supplier`.`supplier_id` = :supplier_id";

			$stmt = $this->connection->prepare($sql);

				return $stmt->execute([
					":supplier_id" => $supplier_id,
				]);
		}

		public function activateSupplier($supplier_id) {
			$sql = "UPDATE `tbl_supplier` SET `supplier_status` = 'Active' WHERE `tbl_supplier`.`supplier_id` = :supplier_id";

			$stmt = $this->connection->prepare($sql);

				return $stmt->execute([
					":supplier_id" => $supplier_id,
				]);
		}

		public function searchSupplier($filter, $keyword) {
			$sql="SELECT supplier_name, supplier_address, supplier_status, supplier_contact_no  FROM tbl_supplier WHERE
				(";
					switch($filter){
		        		case 'name':
				            $sql .= "supplier_name LIKE :keyword)
				            ORDER BY supplier_id;";
				            break;
		                case 'address':
				            $sql .= "supplier_address LIKE :keyword)
				            ORDER BY supplier_id;";
				            break;
				        case 'status':
				            $sql .= "supplier_status LIKE :keyword)
				            ORDER BY supplier_id;";
				            break;
				        case 'contact':
				            $sql .= "supplier_contact_no LIKE :keyword)
				            ORDER BY supplier_id;";
				            break;
				    }
				")";
			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => '%' . $keyword . '%'
			]);

			return $stmt->fetchAll();
		}
	}