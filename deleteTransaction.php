<?php
	ob_start();
	session_start();
	include('classes/Category.php');
	include('classes/Transaction.php');
	include('classes/TransactionType.php');
	include('classes/Debitor.php');
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$db = new DataLayer();
	$accountID = $_GET["ac"];
	$transactionID = $_GET["tran"];

	$trans = $db->getTransactionByID($transactionID);
	$transaction = new Transaction($trans);

	$cat = $db->getCategoryByID($transaction->getCategoryID());
	$category = new Category($cat);

	$debRow = $db->getDebitorByID($transaction->getDebitorID());
	$debitor = new Debitor($debRow);

	if(!empty($_POST['submit'])){	
		$rs = $db->deleteTransactionFromAccount($transactionID, $accountID);

		if ($rs != null) {
			$db->calculateAccountBalance($accountID);
			header("location:account.php?ac={$accountID}");
		} else {
			$error = "There was a problem deleting the transaction.";
		}
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
	<br /><br />
	Are you sure you want to delete this transaction?
	<br />
	<? echo $error; ?>
	<div id="new_item_form">
		<form action="deleteTransaction.php?ac=<? echo $accountID; ?>&tran=<? echo $_GET['tran']?>" method="post">
			<table>
				<tr>
					<td>Date:</td>
					<td><? echo $transaction->getDate() ?></td>
				</tr>
				<tr>
					<td>Category:</td>
					<td><? echo $category->getName(); ?></td>
				</tr>
				<tr>
					<td>Debitor:</td>
					<td><? echo $debitor->getName(); ?></td>
				</tr>
				<tr>
					<td>Amount:</td>
					<td>$<? echo $transaction->getAmount(); ?></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Delete Transaction">
		</form>
	</div>
</body>
</html>