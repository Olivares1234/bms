<?php
	include '../../../private/initialize.php';

	session_destroy();

	header('Location: http://localhost/bms/public/index.php');