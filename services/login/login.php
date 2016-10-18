<?php
	include("../../classes/DataLayer.php");

	$error = "";

	$db = new DataLayer();

	$rs = $db->loginUser($_GET['uname'], $_GET['pass']);

	if ($rs != null) {
		$row = $rs->fetch_assoc();
		$userID = $row['id'];
		$groupID = $row['group_id'];
		$body = "{ \"user\": { \"userID\":$userID, \"groupID\":$groupID } }";

		$status_header = 'HTTP/1.1 ' . 200 . ' All Good';
    	header($status_header);
    	header('Content-type: application/json');
    	echo $body;
	} else {
		$status_header = 'HTTP/1.1 ' . 200 . ' Accepted, but there is a problem';
    	header($status_header);
    	header('Content-type: text/html');
    	echo 'No user';
	}
		
	// EXAMPLE CALL
	//  http://localhost/branvis/bank/services/login/login.php?uname=twade&pass=kitawolf
?>