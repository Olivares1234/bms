<?php

	include '../../../../private/initialize.php';

	$user_type = new User_Type();

	echo json_encode($user_type->retrieveUserType());

	