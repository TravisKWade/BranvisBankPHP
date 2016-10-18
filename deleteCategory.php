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
		$rs = $db->deleteCategoryForGroup($categoryID, $_SESSION["groupID"]);

		if ($rs != null) {
			header("location:categories.php");
		} else {
			$error = "There was a problem deleting the category.";
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
	Are you sure that you want to delete this Category? <br />
	<? echo $error; ?>
	<div id="new_item_form">
		<form action="deleteCategory.php?cat=<? echo $category->getCategoryID() ?>" method="post">
			<? echo $category-> getName(); ?><br />
			<input type="submit" name="submit" value="Delete Category" />
		</form>
	</div>
</body>
</html>