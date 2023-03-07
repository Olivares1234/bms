<?php
 
	class Send_Order_Details {
		public $send_order_details_id;
		public $send_order_id;
		public $purchase_received_details_id;
		public $quantity;

		public $keyword;
		
		private $connection;

		public function __construct() {
			$db = new Database();
			$this->connection = $db->getConnection();
		}

		public function retrieveSendOrderDetails($request_order_id) {
			$sql= "SELECT tbl_send_order.send_order_id, tbl_send_order.user_id, tbl_send_order.request_order_id, tbl_send_order.date_send, tbl_user.first_name, tbl_user.last_name FROM tbl_send_order INNER JOIN tbl_user ON tbl_user.user_id = tbl_send_order.user_id WHERE tbl_send_order.request_order_id = :request_order_id ORDER BY tbl_send_order.send_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":request_order_id" => $request_order_id
			]);

			return $stmt->fetchAll();
		}

		public function addSendOrderDetails() {
			$sql="INSERT INTO `tbl_send_order_details`(`send_order_details_id`, `send_order_id`, `purchase_received_details_id`, `quantity`) VALUES (0, :send_order_id, :purchase_received_details_id, :quantity)";

			$stmt = $this->connection->prepare($sql);

			return $stmt->execute([
				":send_order_id" => $this->send_order_id,
				":purchase_received_details_id" => $this->purchase_received_details_id,
				":quantity" => $this->quantity
			]);
		}

		public function searchSendOrderDetails($keyword) {
			$sql="SELECT tbl_send_order_details.send_order_id, tbl_send_order_details.supplier_medicine_id, tbl_supplier_medicine.medicine_name, tbl_category.description, tbl_unit_category.unit, tbl_supplier_medicine.price, tbl_send_order_details.quantity FROM tbl_send_order_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_send_order_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_supplier_medicine.medicine_name LIKE :keyword OR tbl_category.description LIKE :keyword OR tbl_unit_category.unit LIKE :keyword OR tbl_supplier_medicine.price LIKE :keyword OR tbl_send_order_details.quantity LIKE :keyword ORDER BY tbl_send_order_details.send_order_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":keyword" => "%" . $keyword . "%"
			]);

			return $stmt->fetchAll();
		}

		public function retrieveSendOrderDetailsUsingId($send_order_id) {
			$sql="SELECT tbl_send_order_details.send_order_details_id, tbl_send_order_details.send_order_id, tbl_send_order_details.supplier_medicine_id, tbl_send_order_details.quantity, tbl_supplier_medicine.medicine_name, tbl_supplier_medicine.category_id, tbl_category.description, tbl_supplier_medicine.unit_category_id, tbl_unit_category.unit FROM tbl_send_order_details INNER JOIN tbl_supplier_medicine ON tbl_supplier_medicine.supplier_medicine_id = tbl_send_order_details.supplier_medicine_id INNER JOIN tbl_category ON tbl_category.category_id = tbl_supplier_medicine.category_id INNER JOIN tbl_unit_category ON tbl_unit_category.unit_category_id = tbl_supplier_medicine.unit_category_id WHERE tbl_send_order_details.send_order_id = :send_order_id ORDER BY tbl_send_order_details.send_order_details_id";

			$stmt = $this->connection->prepare($sql);

			$stmt->execute([
				":send_order_id" => $send_order_id
			]);

			return $stmt->fetchAll();
		}

		public function getTotalSendOrder() {
			$sql="WITH orders AS (
				    SELECT
				        YEAR(tbl_date.date) AS Year,
				        DATE_FORMAT(tbl_date.date, '%b') AS Month,
				        MONTH(tbl_date.date) as month_num,
				        COUNT(tbl_send_order_details.send_order_id) AS Total_Order, 
				        SUM(IFNULL(tbl_send_order_details.quantity,0)) AS Quantity, 
				        IFNULL(tbl_supplier_medicine.price,0) AS Price, 
				        IFNULL((tbl_supplier_medicine.price) * 
				        SUM(tbl_send_order_details.quantity),0) AS Total_Amount, 
				        tbl_supplier.supplier_name AS Supplier 
				    FROM tbl_date 
				    LEFT JOIN tbl_send_order
				        ON tbl_send_order.date_send = tbl_date.date 
				    LEFT JOIN tbl_send_order_details
				        ON tbl_send_order.send_order_id = tbl_send_order_details.send_order_id
    				LEFT JOIN tbl_purchase_received_details ON tbl_purchase_received_details.purchase_received_details_id = tbl_send_order_details.purchase_received_details_id
				    LEFT JOIN 
				tbl_supplier_medicine ON tbl_purchase_received_details.supplier_medicine_id = tbl_supplier_medicine.supplier_medicine_id
				    LEFT JOIN tbl_supplier
				        ON tbl_supplier.supplier_id = tbl_supplier_medicine.supplier_id 
				    WHERE YEAR(tbl_date.date) = YEAR(NOW())
				    GROUP BY Month, month_num, tbl_supplier_medicine.supplier_medicine_id
				)
                SELECT 
				    Month,
				    COALESCE(SUM(Quantity),0) AS Quantity, 
				    COALESCE(SUM(Total_Amount),0) AS Total_Amount
				from orders 
				GROUP BY Month, month_num
				ORDER BY month_num";

			$stmt = $this->connection->prepare($sql);

				$stmt->execute();

				return $stmt->fetchAll();
		}
	}