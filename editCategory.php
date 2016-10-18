<?php
	ob_start();
	session_start();
	include("classes/DataLayer.php");
	include('classes/Category.php');

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	}

	$error = "";
	$db = new DataLayer();
	$categoryID = $_GET["cat"];

	$category = new Category($db->getCategoryByID($categoryID));

	if(!empty($_POST['submit'])){	
		if(!empty($_POST['name'])){
			$rs = $db->updateCategory($_SESSION['groupID'], $category->getCategoryID(), $_POST['name']);

			if ($rs != null) {
				header("location:categories.php");
			} else {
				$error = "There was a problem updating the category";
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
		<form action="editCategory.php?cat=<? echo $category->getCategoryID() ?>" method="post">
			<table>
				<tr>
					<td>Category Name:</td>
					<td><input type="text" name="name" value="<? echo $category->getName() ?>"/></td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Update Category" />
		</form>
	</div>
</body>
</html>