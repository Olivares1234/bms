<?php

	include '../../../private/initialize.php';

	$transaction = new Transaction();
	
	echo json_encode($transaction->searchTransaction($_GET['keyword']));