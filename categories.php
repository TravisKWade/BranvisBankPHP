<?php
	session_start();
	include("classes/Category.php");
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	} 

	$db = new DataLayer();

	$rs = $db->getCategoriesForGroup($_SESSION['groupID']);
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
	<div>Categories</div>
	<? 
		if ($rs != null) {
			$rows = $rs->num_rows;
			if ($rows > 0) {
				while($row = $rs->fetch_assoc()) {
					$category = new Category($row);
					echo "<a href='editCategory.php?cat={$category->getCategoryID()}'> EDIT </a> <a href='deleteCategory.php?cat={$category->getCategoryID()}'> DELETE</a> -- {$category->getName()}<br />";
				}
			} else {
				echo "There are no categories yet";
			} 
		} else {
			echo "There are no categories yet";
		}
	?>

	<br /><br />
	<a href="newCategory.php">Create New Category</a>
</body>
</html>