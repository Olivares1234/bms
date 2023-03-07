<?php

	include '../../../../private/initialize.php';

	$civil_status = new Civil_Status();

	echo json_encode($civil_status->retrieveCivilStatus());