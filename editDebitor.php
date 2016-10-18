<?php
	ob_start();
	session_start();
	include("classes/DataLayer.php");
	include('classes/Debitor.php');

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$error = "";
	$db = new DataLayer();
	$debitorID = $_GET["deb"];

	$debitor = new Debitor($db->getDebitorByID($debitorID));

	if(!empty($_POST['submit'])){	
		if(!empty($_POST['name'])){
			$rs = $db->updateDebitor($_SESSION['groupID'], $debitor->getDebitorID(), $_POST['name']);

			if ($rs != null) {
				header("location:debitors.php");
			} else {
				$error = "There was a problem updating the debitor";
			}
		} else {
			$error = "Please enter a Debitor";
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
	<div id="new_item_form">
		<form action="editDebitor.php?deb=<? echo $debitor->getDebitorID() ?>" method="post">
			<table>
				<tr>
					<td>Debitor Name:</td>
					<td><input type="text" name="name" value="<? echo $debitor->getName() ?>"/></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Update Debitor" />
		</form>
	</div>
</body>
</html>