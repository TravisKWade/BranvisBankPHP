<?php
	session_start();
	include("classes/Account.php");
	include("classes/Transaction.php");
	include("classes/TransactionType.php");
	include("classes/Category.php");
	include("classes/Debitor.php");
	include("classes/DataLayer.php");

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$db = new DataLayer();
	
	// get the category data
	$categoryArray = array();
	$catRS = $db->getCategoriesForGroup($_SESSION['groupID']);

	if ($catRS != null) {
		while($catRow = $catRS->fetch_assoc()) {
			$category = new Category($catRow);
			$categoryArray[$category->getCategoryID()] = $category;
		}
	}

	// get the debitors
	$debitorArray = array();
	$debitorRS = $db->getDebitorsForGroup($_SESSION['groupID']);

	while($debitorRow = $debitorRS->fetch_assoc()) {
		$debitor = new Debitor($debitorRow);
		$debitorArray[$debitor->getDebitorID()] = $debitor;
	}

	// get the transaction types
	$typeArray = array();
	$typeRS = $db->getTransactionTypes();
	
	while($typeRow = $typeRS->fetch_assoc()) {
		$type = new TransactionType($typeRow);
		$typeArray[$type->getTransactionTypeID()] = $type;
	}

	// get the account info
	$accountID = $_GET['ac'];
	$accountRS = $db->getAccountByID($accountID);

	if ($accountRS != null) {
		$accountRow = $accountRS->fetch_assoc();
		$account = new Account($accountRow);
	}

	// get the transactions for the account
	$rs = $db->getTransactionsForAccount($accountID);
?>

<html>
<head>
	<title>BANKING APP - BRANVIS</title>
	<script src="scripts/jquery-2.2.1.min.js"></script>
	<script src="scripts/account.js"></script>
</head>
<body>
	User: <? echo $_SESSION['user']; ?>
	<input type="hidden" id="user" value="<? echo $_SESSION['userID'] ?>" />
	<input type="hidden" id="group" value="<? echo $_SESSION['groupID'] ?>" />
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
	<a href="newTransaction.php?ac=<? echo $accountID; ?>">Create New Transaction</a><br /><br />
	<div class="accountName"><? echo $account->getName(); ?> balance: <? echo $account->getBalance(); ?></div>
	<table>
		<tr>
			<td></td>
			<td></td>
			<td>Date</td>
			<td>Debitor</td>
			<td>Category</td>
			<td>Debits</td>
			<td>Credits</td>
			<td>Reconciled</td></tr>
		<?
		 if ($rs != null) {
			 while($row=$rs->fetch_assoc()) {
			 	$transaction = new Transaction($row);

			 	$cat = $categoryArray[$transaction->getCategoryID()];
		 ?>
		 	<tr>
		 	<td><a href="editTransaction.php?tran=<? echo $transaction->getTransactionID(); ?>&ac=<? echo $accountID; ?>">EDIT</a></td>
		 	<td><a href="deleteTransaction.php?tran=<? echo $transaction->getTransactionID(); ?>&ac=<? echo $accountID; ?>">DELETE</a></td>
		 	<td><? echo $transaction->getDate(); ?></td>
		 	<td><? echo $debitorArray[$transaction->getDebitorID()]->getName(); ?></td>
		 	<td><? echo $cat->getName(); ?></td>
		 	<td><? if ($typeArray[$transaction->getTransactionTypeID()]->getIsDebit()) { echo $transaction->getAmount(); } ?></td>
		 	<td><? if (!$typeArray[$transaction->getTransactionTypeID()]->getIsDebit()) { echo $transaction->getAmount(); } ?></td>
		 	<td><input type="checkbox" id="<? echo $transaction->getTransactionID(); ?>" <? if ($transaction->getReconciled() == 1) { echo "checked"; } ?>></td>
		 	</tr>

		<?
		 	}
		 }
		?>

	</table>
</body>
</html>