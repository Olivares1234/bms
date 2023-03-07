<?php
	include '../../../../private/initialize.php';

	$user = new User();

	$data = json_decode(file_get_contents("php://input"),true);

	$user->username = "bms123";
	$user->password = "bms123";

	$user->resetAccount($data['user_id']);
	
		
	

