<?
	ob_start();
	session_start();
	include("classes/Debitor.php");
	include("classes/DataLayer.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	} 

	$db = new DataLayer();

	$rs = $db->getDebitors($_SESSION['groupID']);
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
	<div>Debitors</div>
	<? 
		if ($rs != null) {
			$rows = $rs->num_rows;
			if ($rows > 0) {
				while($row = $rs->fetch_assoc()) {
					$debitor = new Debitor($row);
					echo "<a href='editDebitor.php?deb={$debitor->getDebitorID()}'> EDIT </a> <a href='deleteDebitor.php?deb={$debitor->getDebitorID()}'> DELETE</a> -- {$debitor->getName()}<br />";
				}
			} else {
				echo "There are no debitors yet";
			} 
		} else {
			echo "There are no debitors yet";
		}
	?>

	<br /><br />
</body>
</html>