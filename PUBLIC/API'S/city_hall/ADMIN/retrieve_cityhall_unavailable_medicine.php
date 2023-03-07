<?php

	include '../../../../private/initialize.php';

	$medicine = new Medicine();

	echo json_encode($medicine->getAllUnavailableMedicine());