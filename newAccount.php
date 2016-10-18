<?php
	ob_start();
	session_start();
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$db = new DataLayer();
	$error = "";

	if(!empty($_POST['submit'])){	
		if(!empty($_POST['name'])){
			$balance = str_replace("$", "", $_POST['balance']);
		}

		$rs = $db->createAccountForGroup($_SESSION['groupID'], $_POST['name'], $balance, $_SESSION["userID"]);
		
		if($rs != null) {
			header("location:index.php");
		} else {
			$error = "There was a problem creating the account";
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
	<? echo $error; ?>
	<div id="new_account_form">
		<form action="newAccount.php" method="post">
			<table>
				<tr>
					<td>Account Name:</td>
					<td><input type="text" name="name" /></td>
				</tr>
				<tr>
					<td>Starting Balance:</td>
					<td><input type="text" name="balance" value="$0.00" /></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Create New Account">
		</form>
	</div>
</body>
</html>