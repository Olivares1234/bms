<?php

	include '../../../../private/initialize.php';

	$medicine = new Purchase_Received_Details();
	
	echo json_encode($medicine->searchCityHallAvailableMedicine($_GET['filter'], $_GET['keyword']));