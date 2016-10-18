<?
	ob_start();
	session_start();
	include("classes/Account.php");
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	} 

	$accounts = "";
	$db = new DataLayer();
	$db->updateAccountBalancesForGroup($_SESSION['groupID']);
	$rs = $db->getAccountsForGroup($_SESSION['groupID']);
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
		<li><a href="schedule.php">Scheduled Transactions</a></li>
		<li>Reports</li>
	</ul>
	<? 
		$rows = $rs->num_rows;
		if ($rs != null) {
			while($row = $rs->fetch_assoc()) {
				$account = new Account($row);
				echo "<a href='editAccount.php?ac={$account->getAccountID()}'>EDIT</a> -- <a href='account.php?ac={$account->getAccountID()}'>{$account->getName()}</a>  \${$account->getBalance()}<br />";
			}
		} else {
			echo "There are no accounts setup";
		} 
	?>

	<br /><br />
	<a href="newAccount.php">Create New Account</a>
</body>
</html>