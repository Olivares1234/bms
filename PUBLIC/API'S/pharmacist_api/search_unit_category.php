<?php

	include '../../../private/initialize.php';

	$unit_category = new Unit_Category();
	
	echo json_encode($unit_category->searchUnitCategory($_GET['keyword']));