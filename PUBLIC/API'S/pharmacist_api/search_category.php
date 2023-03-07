<?php

	include '../../../private/initialize.php';

	$category = new Category();
	
	echo json_encode($category->searchCategory($_GET['keyword']));