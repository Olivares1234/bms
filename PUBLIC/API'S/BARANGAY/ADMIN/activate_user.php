<?php
	include '../../../../private/initialize.php';

	$user = new User();

	$data = json_decode(file_get_contents("php://input"),true);

	$user->activateUser($data['user_id']);
	
		
	

