<?php
	ob_start();
	session_start();
	include('classes/Category.php');
	include('classes/TransactionType.php');
	include('classes/Debitor.php');
	include("classes/DataLayer.php");

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$error = "";
	$accountID = $_GET["ac"];
	$db = new DataLayer();

	if(!empty($_POST['submit'])){	
		if(!empty($_POST['debitor']) && !empty($_POST['amount'])) {
			$date = $_POST['date'];
			if (empty($date)) {
				date_default_timezone_set('America/Los_Angeles');
				date_default_timezone_get();
				$today = getdate();
				$date = "{$today['year']}-{$today['mon']}-{$today['mday']}";
			}

			$amount = $_POST['amount'];
			$categoryID = $_POST['category'];
			$typeID = $_POST['type'];
			$debitor = $_POST['debitor'];

			$debitorID = $db->addDebitorForGroup($_SESSION['groupID'], $debitor);

			$rs = $db->createTransactionForAccount($accountID, $amount, $date, $categoryID, $typeID, $debitorID, $_SESSION['userID']);

			if ($rs != null) {
				$db->calculateAccountBalance($accountID);
				header("location:account.php?ac=$accountID");
			} else {
				$error = "There was a problem createing the transaction";
			}
		} else {
			$error = "Please enter where the transaction took place and the amount";
		}
	}

	// get the category data
	$categoryArray = array();
	$catRS = $db->getCategoriesForGroup($_SESSION['groupID']);

	if ($catRS != null) {
		while($catRow = $catRS->fetch_assoc()) {
			$category = new Category($catRow);
			$categoryArray[$category->getCategoryID()] = $category;
		}
	}

	// get the transaction types
	$typeArray = array();
	$typeRS = $db->getTransactionTypes();
	
	while($typeRow = $typeRS->fetch_assoc()) {
		$type = new TransactionType($typeRow);
		$typeArray[$type->getTransactionTypeID()] = $type;
	}

	// get the debitors
	$debitorArray = array();
	$debitorRS = $db->getDebitorsForGroup($_SESSION['groupID']);

	while($debitorRow = $debitorRS->fetch_assoc()) {
		$debitor = new Debitor($debitorRow);
		$debitorArray[$debitor->getDebitorID()] = $debitor;
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
	<? echo $error; ?>
	<div id="new_item_form">
		<form action="newTransaction.php?ac=<? echo $accountID; ?>" method="post">
			<table>
				<tr>
					<td>Date:</td>
					<td><input type="date" name="date" /></td>
				</tr>
				<tr>
					<td>Category:</td>
					<td>
						<select name="category">
						<?
							foreach($categoryArray as $cat) {
								echo "<option value=\"{$cat->getCategoryID()}\">{$cat->getName()}</option>";
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Debitor:</td>
					<td>
						<input type="text" name="debitor" />
						<datalist id="debitor">
						<?
							foreach($debitorArray as $debitor) {
								echo "<option value=\"{$debitor->getName()}\">";
							}
						?>
						</datalist>
					</td>
				</tr>
				<tr>
					<td>Amount:</td>
					<td><input type="text" name="amount" /></td>
				</tr>
				<tr>
					<td>Type:</td>
					<td>
						<select name="type">
						<?
							foreach($typeArray as $type) {
								$selected = "";
								if ($type->getTransactionTypeID() == 1) { $selected = "selected"; }
								echo "<option value=\"{$type->getTransactionTypeID()}\" $selected>{$type->getName()}</option>";
							}
						?>
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Create New Transaction">
		</form>
	</div>
</body>
</html>