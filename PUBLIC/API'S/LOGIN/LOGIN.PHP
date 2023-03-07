<?php
	include '../../../private/initialize.php';

	$user = new User();

	$data = json_decode(file_get_contents("php://input"),true);

	$user->username = $data['username'];
	$user->password = $data['password'];

	$user->getActiveUser();