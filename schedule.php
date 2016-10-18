<?php
	ob_start();
	session_start();
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	} 

	$db = new DataLayer();

?>

<html>
<head>
	<title>BANKING APP - BRANVIS</title>
</head>
<body>
	User: <? echo $_SESSION['user']; ?><br />
	<form action="logout.php">
		<input type="submit" value="Logout" />
	</form>
	<ul>
		<li><a href="index.php">Accounts</a></li>
		<li><a href="categories.php">Categories</a></li>
		<li><a href="debitors.php">Debitors</a></li>
		<li>Scheduled Transaction</li>
		<li>Reports</li>
	</ul>
	<div>Scheduled Transactions</div>
	<a href="newSchedule.php">Create New Scheduled Transaction</a>
	
	<br /><br />
</body>
</html>