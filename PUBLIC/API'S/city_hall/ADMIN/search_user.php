<?php

	include '../../../../private/initialize.php';

	$user = new User();
	
	echo json_encode($user->searchAllUser($_GET['filter'], $_GET['keyword']));