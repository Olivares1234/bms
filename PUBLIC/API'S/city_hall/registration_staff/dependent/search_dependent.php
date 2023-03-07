<?php

	include '../../../../../private/initialize.php';

	$dependent = new Dependent();
	
	echo json_encode($dependent->searchDependent($_GET['filter'], $_GET['keyword']));