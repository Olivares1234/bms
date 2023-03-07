<?php

	include '../../../private/initialize.php';

	$category = new Category();

	echo json_encode($category->getAllCategory());