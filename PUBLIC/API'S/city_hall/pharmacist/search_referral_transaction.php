
<?php

	include '../../../../private/initialize.php';

	$referral_transaction = new Referral_Transaction();
	
	echo json_encode($referral_transaction->searchReferralTransaction($_GET['keyword']));