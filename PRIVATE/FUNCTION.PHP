<?php

	function url_for($script_path) {
		if($script_path[0] != '/') {
			$script_path = "/" . $script_path;
		}
		return WWW_ROOT . $script_path;
	}

	function checkSession() {
		if(isset($_SESSION['user_type_id']) && isset($_SESSION['barangay_id'])) {
			if($_SESSION['user_type_id'] == '4') {
				header("Location: /bms/public/pages/barangay/health_worker/dashboard.php");
			}
			else if($_SESSION['user_type_id'] == 1 && $_SESSION['barangay_id'] != 19) {
				header("Location: /bms/public/pages/barangay/admin/dashboard.php");
			}
			else if($_SESSION['user_type_id'] == 1 && $_SESSION['barangay_id'] == 19) {
				header("Location: /bms/public/pages/city_hall/admin/dashboard.php");
			}
			else if($_SESSION['user_type_id'] == 2 && $_SESSION['barangay_id'] == 19) {
				header("Location: /bms/public/pages/city_hall/pharmacist/dashboard.php");
			}
			else if($_SESSION['user_type_id'] == 3 && $_SESSION['barangay_id'] == 19) {
				header("Location: /bms/public/pages/city_hall/registration_staff/dashboard.php");
			}
		}
	}
?>