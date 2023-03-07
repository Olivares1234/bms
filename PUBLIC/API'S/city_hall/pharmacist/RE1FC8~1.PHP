<?php

	include '../../../../private/initialize.php';

	$purchase_received = new Purchase_Received();

	echo json_encode($purchase_received->retrievePurchaseReceived());