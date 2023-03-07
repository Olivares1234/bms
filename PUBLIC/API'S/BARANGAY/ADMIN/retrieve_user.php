<?php

	include '../../../../private/initialize.php';

	$user = new User();

	echo json_encode($user->retrieveUser($_SESSION['user_id'], $_SESSION['barangay_id']));

	