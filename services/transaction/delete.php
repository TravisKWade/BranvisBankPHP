<?php
	include("../../classes/DataLayer.php");

	$db = new DataLayer();

	$accountID = $_GET["acc"];
	$transactionID = $_GET["tran"];

	$rs = $db->deleteTransactionFromAccount($transactionID, $accountID);

	if ($rs != null) {
		$db->calculateAccountBalance($accountID);
		echo 1;
	} else {
		echo 0;
	}

	// EXAMPLE CALL
	//  http://localhost/branvis/bank/services/transaction/delete.php?tran=25&acc=1
?>