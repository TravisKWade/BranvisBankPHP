<?php
	ob_start();
	session_start();
	include("classes/DataLayer.php");
	include("classes/Category.php");
	include("classes/Debitor.php");
	include("classes/ScheduleType.php");
	include("classes/TransactionType.php");

	if(!isset($_SESSION['user']) || !isset($_SESSION['userID'])) {
		header("location:login.php");
	} 

	$db = new DataLayer();

	if(!empty($_POST['submit'])){	
		if (!empty($_POST["debitor"]) && !empty($_POST["amount"])) {

			$debitorID = $db->addDebitorForGroup($_SESSION['groupID'], $debitor);

			
		} else {
			$error = "Please make sure that all of the fields are filled out.";
		}
	}

	// get the schedule type
	$scheduleTypeArray = array();
	$stRS = $db->getScheduleTypesForGroup($_SESSION['groupID']);

	if ($stRS != null) {
		while($stRow = mysql_fetch_array($stRS)) {
			$scheduleType = new ScheduleType($stRow);
			$scheduleTypeArray[$scheduleType->getScheduleTypeID()] = $scheduleType;
		}
	}

	// get the category data
	$categoryArray = array();
	$catRS = $db->getCategoriesForGroup($_SESSION['groupID']);

	if ($catRS != null) {
		while($catRow = mysql_fetch_array($catRS)) {
			$category = new Category($catRow);
			$categoryArray[$category->getCategoryID()] = $category;
		}
	}

	// get the transaction types
	$typeArray = array();
	$typeRS = $db->getTransactionTypes();
	
	while($typeRow = mysql_fetch_array($typeRS)) {
		$type = new TransactionType($typeRow);
		$typeArray[$type->getTransactionTypeID()] = $type;
	}

	// get the debitors
	$debitorArray = array();
	$debitorRS = $db->getDebitorsForGroup($_SESSION['groupID']);

	while($debitorRow = mysql_fetch_array($debitorRS)) {
		$debitor = new Debitor($debitorRow);
		$debitorArray[$debitor->getDebitorID()] = $debitor;
	}
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
		<li>Scheduled Transaction</li>
		<li>Reports</li>
	</ul>
	<div>New Scheduled Transaction</div>
	<? echo $error; ?>
	<div id="new_item_form">
		<form action="newSchedule.php" method="post">
			<table>
				<tr>
					<td>Schedule Type:</td>
					<td>
						<select name="scheduleType">
						<?
							foreach($scheduleTypeArray as $scheduleType) {
								echo "<option value=\"{$scheduleType->getScheduleTypeID()}\">{$scheduleType->getName()}</option>";
							}
						?>
						</select>
					</td>
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
								echo "<option value=\"{$type->getTransactionTypeID()}\">{$type->getName()}</option>";
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Unit:</td>
					<td>
						<select name="unit">
							<option value="week">Week</option>
							<option value="month">Month</option>
							<option value="year">Year</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Step:</td>
					<td>
						<select name="step">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Day Of Week:</td>
					<td>
						<select name="dayOfWeek">
							<option value="sunday">Sunday</option>
							<option value="monday">Monday</option>
							<option value="tuesday">Tuesday</option>
							<option value="wednesday">Wednesday</option>
							<option value="thursday">Thursday</option>
							<option value="friday">Friday</option>
							<option value="saturday">Saturday</option>
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Create New Scheduled Transaction">
		</form>
	</div>
</body>
</html>