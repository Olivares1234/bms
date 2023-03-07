<?php

	include '../../../../private/initialize.php';

	$purchase_order = new Purchase_Order();
	
	echo json_encode($purchase_order->searchCityHallExpiredMedicine($_GET['keyword']));