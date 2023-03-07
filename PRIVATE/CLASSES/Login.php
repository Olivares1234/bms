<?php
	session_start();

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'bms');

	// variable declaration
	$username = "";
	$email    = "";
	$errors   = array(); 

	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: index.php");
	}

	// LOGIN USER
	function login(){
		global $db, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = $password;

			$query = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['barangay_id'] == 1) {

					$_SESSION['user'] = $logged_in_user;
					header('location: ../../bms/public/gulod/index.php');		  
				} else if($logged_in_user['barangay_id'] == 2){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 3){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 4){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 5){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 6){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 7){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 8){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 9){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 10){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 11){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 12){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 13){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 14){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 15){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 16){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else if($logged_in_user['barangay_id'] == 17){
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				} else {
					$_SESSION['user'] = $logged_in_user;

					header('location: ../../bms/public/mamatid/index.php');
				}
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}
