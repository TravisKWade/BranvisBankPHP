<?php
	ob_start();
	session_start();
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$error = "";
	$db = new DataLayer();

	if(!empty($_POST['submit'])){	
		if(!empty($_POST['name'])){
			$rs = $db->createCategoryForGroup($_SESSION['groupID'], $_POST['name']);

			if ($rs != null) {
				header("location:categories.php");
			} else {
				$error = "There was a problem creating the category";
			}
		} else {
			$error = "Please enter a Category";
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
		<form action="newCategory.php" method="post">
			<table>
				<tr>
					<td>Category Name:</td>
					<td><input type="text" name="name" /></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Create New Category" />
		</form>
	</div>
</body>
</html>