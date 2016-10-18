<?php
	include("../../classes/DataLayer.php");

	$db = new DataLayer();

	$accountID = $_GET["acc"];
	$groupID = $_GET["group"];
	$userID = $_GET["user"];
	$amount = $_GET["amt"];
	$userID = $_GET["user"];
	$categoryID = $_GET["cat"];
	$typeID = $_GET["type"];
	$date = $_GET["date"];

	$debitor = $_GET['debitor'];

	$debitorID = $db->addDebitorForGroup($groupID, urldecode($debitor));

	$rs = $db->createTransactionForAccount($accountID, $amount, $date, $categoryID, $typeID, $debitorID, $userID);

	if ($rs != null) {
		$db->calculateAccountBalance($accountID);
		echo 1;
	} else {
		echo 0;
	}

	// EXAMPLE CALL
	//  http://localhost/branvis/bank/services/transaction/create.php?acc=1&user=1&group=1&amt=250.35&cat=5&type=1&date=2016-03-01&debitor=Bean
?>