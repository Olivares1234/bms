<?php

	include '../../../private/initialize.php';

	$user = new User();
	
	echo json_encode($user->searchUserStatus($_GET['keyword']));