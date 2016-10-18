<?php
	include("../../classes/DataLayer.php");

	$groupID = $_GET["group"];
	$transactionID = $_GET["trans"];
	$reconciled = $_GET["rec"];
	$userID = $_GET["user"];

	$db = new DataLayer();

	if($db->checkUserInGroup($userID, $groupID)) {
		$db->markTransactionReconciled($reconciled, $transactionID);
		echo 1;
	} else {
		echo 0;
	}

?>