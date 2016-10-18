<?php
	ob_start();
	session_start();
	include("classes/Account.php");
	include("classes/Transaction.php");
	include("classes/TransactionType.php");
	include("classes/Category.php");
	include("classes/Debitor.php");
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$db = new DataLayer();

	// get the account info
	$accountID = $_GET['ac'];
	$accountRS = $db->getAccountByID($accountID);

	if ($accountRS != null) {
		$accountRow = $accountRS->fetch_assoc();
		$account = new Account($accountRow);
	}

	if(!empty($_POST['submit'])){	
		if(!empty($_POST['name'])){
			$db->updateAccountForGroup($accountID, $_SESSION['groupID'], $_POST['name']);
			header("location:index.php");
		} else {
			$error = "Please enter a name for the account";
		}
	} else if(!empty($_POST['delete'])) {
		$db->deleteAccountForGroup($accountID, $_SESSION['groupID']);
		header("location:index.php");
	}
?>

<html>
<head>
	<title>BANKING APP - BRANVIS</title>
</head>
<body>
	User: <? echo $_SESSION['user']; ?>
	<form action="logout.php">
		<input type="submit" value="Logout" />
	</form>
	<ul>
		<li><a href="index.php">Accounts</a></li>
		<li><a href="categories.php">Categories</a></li>
		<li><a href="debitors.php">Debitors</a></li>
		<li>Bills</li>
		<li>Reports</li>
	</ul>
	Edit Account<br/><br />
	<? echo $error; ?>
	<div id="new_account_form">
		<form action="editAccount.php?ac=<? echo $accountID; ?>" method="post">
			<table>
				<tr>
					<td>Account Name:</td>
					<td><input type="text" name="name" value="<? echo $account->getName(); ?>" /></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Update Account">
		</form>
	</div>
	<div id="new_account_form">
		<form action="editAccount.php?ac=<? echo $accountID; ?>" method="post">
			<input type="submit" name="delete" value="Delete Account">
		</form>
	</div>
</body>
</html>