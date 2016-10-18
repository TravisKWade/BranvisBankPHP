<?php
	ob_start();
	include("../../classes/DataLayer.php");
	include("../../classes/Account.php");

	$accounts = "";
	$db = new DataLayer();
	$rs = $db->getAccountsForGroup($_GET['gid']);

	if ($rs != null) {
		$body = " { \"accounts\": [";

		while($row = $rs->fetch_assoc()) {
			$account = new Account($row);
			$body = $body."{ \"accountID\":".$account->getAccountID().", \"accountName\":\"".$account->getName()."\" },"; 
		}
		$body = rtrim($body, ",");
		$body = $body." ]}";

		$status_header = 'HTTP/1.1 ' . 200 . ' All Good';
    	header($status_header);
    	header('Content-type: application/json');
    	echo $body;
	} else {
		$status_header = 'HTTP/1.1 ' . 200 . ' Accepted, but there is a problem';
    	header($status_header);
    	header('Content-type: text/html');
    	echo 'No Accounts';
	}

	// EXAMPLE CALL
	//  http://localhost/branvis/bank/services/account/accounts.php?gid=1
?>