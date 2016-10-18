<?php

class DataLayer {
	private $db;

	/********************
		Constructor
	*********************/
	public function __construct() {
		//$this->$db = mysql_connect('branvisc.ipowermysql.com','kitawolf','marshal72');
		//$this->db = mysql_connect('localhost','root','kitawolf');

		//$this->db = new mysqli('branvisc.ipowermysql.com','kitawolf','marshal72', 'bank');
		$this->db = new mysqli('localhost','root','kitawolf', 'bank');

		// Check connection
		if ($this->db->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
	}

	function __destruct() {
       //mysql_close($this->db);
		mysqli_close($this->db);
   	}

	/********************
		User functions
	*********************/

	public function loginUser($email, $password) {
		$sql = "select * from user where email='{$email}' and password='{$password}' and active=1";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs;
		}
			
		return;
	}

	public function checkUserInGroup($userID, $groupID) {
		$sql = "select * from user where id = {$userID} and group_id = {$groupID} and active = 1";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	/*************************
		Account functions
	**************************/

	public function updateAccountBalancesForGroup($groupID) {
		$accounts = $this->getAccountsForGroup($groupID);

		while($row = $accounts->fetch_assoc()) {
			$this->calculateAccountBalance($row['id']);
		}
	}

	public function getAccountsForGroup($groupID) {
		$sql = "select * from account where group_id = {$groupID} and active = 1";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs;
		}
			
		return;
	}

	public function getAccountByID($accountID) {
		$sql = "select * from account where id = {$accountID}";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs;
		}
			
		return;
	}

	public function createAccountForGroup($groupID, $name, $balance, $userID) {
		$sql = "insert into account (name, group_id, active) values ('{$name}', {$groupID}, 1);";
		$rs = $this->db->query($sql);
		$newID = $this->db->insert_id;

		// create a new transaction to start the account
		// get the deposit id
		$depositID = $this->getDepositID();

		// set the date
		date_default_timezone_set('America/Los_Angeles');
		date_default_timezone_get();
		$today = getdate();
		$date = "{$today['year']}-{$today['mon']}-{$today['mday']}";

		$this->createTransactionForAccount($newID, $balance, $date, 1, $depositID, 0, $userID);
		$this->calculateAccountBalance($newID);

		return $rs;
	}

	public function calculateAccountBalance($accountID) {
		$balance = 0;

		// TODO: don't grab anything past today's date
		$sql = "select * from transaction where account_id = {$accountID} and active = 1 order by date";
		$rs = $this->db->query($sql);

		$balance = 0;

		// something to think about, we might have to add a descriminator to the transaction type
		//		so we can easily tell if it adds or subtracts from the account
		// get the transaction types
		$typeArray = array();
		$typeRS = $this->getTransactionTypes();
		
		if ($rs->num_rows > 0) {
			while($typeRow = $typeRS->fetch_assoc()) {
				$typeArray[$typeRow['id']] = $typeRow['name'];
			}

			while($row = $rs->fetch_assoc()) {

				// figure out debit/deposit
				if($typeArray[$row['transaction_type_id']] == "Deposit") {
					$balance = $balance + $row['amount'];
				} else {
					$balance = $balance - $row['amount'];
				}
			} 
		}

		$this->updateAccountBalance($accountID, $balance);
	}

	public function updateStaticAccountBalance($accountID) {
		// RULES:
		//	must be reconciled
		//	not in the future



		// get the last account balance

		// check to see if there are transaction that can be added to the static balance

		// create new static balance
	}

	public function calculateCurrentAccountBalance($accountID) {
		// only included reconciled items from the past. Should match up to bank balance
	}

	public function calculateTotalAccountBalance($accountID) {
		// All items entered past & future. includes non reconciled transactions
	}

	public function calculateMainAccountBalance($accountID) {
		// Items that have been entered but are in the past. Includes non reconciled transactions
	}

	public function deleteAccountForGroup($accountID, $groupID) {
		$sql = "update account set active = 0 where id = {$accountID} and group_id = {$groupID}";
		$rs = $this->db->query($sql);
		
		// TODO: think about: do we want to set all of the transaction to active = 0?
		//			not doing it now to save account state. the account will not be accessable, so it might be ok
		return;
	}

	public function updateAccountForGroup($accountID, $groupID, $name) {
		$sql = "update account set name = '{$name}' where id = {$accountID} and group_id = {$groupID}";
		$rs = $this->db->query($sql);
	
		return;
	}

	public function updateAccountBalance($accountID, $balance) {
		$sql = "update account set balance = {$balance} where id = {$accountID}";
		$rs = $this->db->query($sql);

		return;
	}

	/*************************
		Category functions
	**************************/

	public function getCategoryByID($categoryID) {
		$sql = "select * from category where id = {$categoryID}";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs->fetch_assoc();
		}
			
		return;
	}

	public function getCategoriesForGroup($groupID) {
		$sql = "select * from category where group_id = {$groupID} and admin = 0 and active = 1 order by name";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs;
		}
			
		return;
	}

	public function createCategoryForGroup($groupID, $name) {
		$sql = "insert into category (name, group_id, active, admin) values ('{$name}', {$groupID}, 1, 0)";
		$rs = $this->db->query($sql);

		if ($rs != null) {
			return $rs;
		}
			
		return;
	}

	public function deleteCategoryForGroup($categoryID, $groupID) {
		$sql = "update category set active = 0 where id = {$categoryID} and group_id = {$groupID}";
		return $this->db->query($sql);
	}

	public function updateCategory($groupID, $categoryID, $name) {
		$sql = "update category set name = '{$name}' where id = {$categoryID} and group_id = {$groupID}";
		$rs = $this->db->query($sql);

		return $rs;
	}

	/*************************
		Transaction functions
	**************************/

	public function getTransactionsForAccount($accountID) {
		$sql = "select * from transaction where account_id = {$accountID} and active = 1 order by date desc, created_at desc";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs;
		}
			
		return;
	}

	public function createTransactionForAccount($accountID, $amount, $date, $categoryID, $typeID, $debitorID, $userID) {
		$sql = "insert into transaction (account_id, amount, date, category_id, transaction_type_id, debitor_id, reconciled, active, user_id) values ({$accountID}, {$amount}, '{$date}', {$categoryID}, {$typeID}, {$debitorID}, 0, 1, {$userID});";
		$rs = $this->db->query($sql);
	
		if ($rs != null) {
			return $rs;
		}
			
		return;
	}

	public function updateTransaction($transactionID, $amount, $date, $categoryID, $typeID, $debitorID) {
		$sql = "update transaction set amount = {$amount}, date = '{$date}', category_id = {$categoryID}, transaction_type_id = {$typeID}, debitor_id = {$debitorID} where id = {$transactionID}";
		$rs = $this->db->query($sql);

		if ($rs != null) {
			return $rs;
		}
			
		return;
	}

	public function deleteTransactionFromAccount($transactionID, $accountID) {
		$sql = "update transaction set active = 0 where id = {$transactionID} and account_id = {$accountID}";
		return $this->db->query($sql);
	}

	public function markTransactionReconciled($reconciled, $transactionID) {
		$sql = "update transaction set reconciled = {$reconciled} where id = {$transactionID}";
		return $this->db->query($sql);
	}

	public function getTransactionByID($transactionID) {
		$sql = "select * from transaction where id = {$transactionID}";
		$rs = $this->db->query($sql);

		if ($rs != null) {
			return $rs->fetch_assoc();
		}

		return;
	}

	/*************************
		Transaction Type functions
	**************************/

	public function getDepositID() {
		$sql = "select id from transaction_type where name = 'Deposit'";
		$rs = $this->db->query($sql);

		$row = $rs->fetch_assoc();
		return $row['id'];
	}

	public function getTransactionTypes() {
		$sql = "select * from transaction_type order by name";
		$rs = $this->db->query($sql);

		if ($rs != null) {
			return $rs;
		}

		return;
	}

	/*************************
		Debitor functions
	**************************/

	public function getDebitorByID($debitorID) {
		$sql = "select * from debitor where id ={$debitorID}";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs->fetch_assoc();
		}
			
		return;
	}

	public function getDebitorsForGroup($groupID) {
		$sql = "select * from debitor where group_id = {$groupID} order by select_weight desc";
		$rs = $this->db->query($sql);

		if ($rs != null) {
			return $rs;
		}

		return;
	}

	public function getDebitors($groupID) {
		$sql = "select * from debitor where group_id = {$groupID} and active = 1 order by name";
		$rs = $this->db->query($sql);

		if ($rs != null) {
			return $rs;
		}

		return;
	}

	public function getDebitorByNameForGroup($groupID, $name) {
		$sql = "select * from debitor where name = \"{$name}\" and group_id = {$groupID}";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs;
		}

		return;		
	}

	public function addDebitorForGroup($groupID, $name) {
		// see if the debitor is in there first
		$debitorRS = $this->getDebitorByNameForGroup($groupID, $name);

		$sql = "";

		if($debitorRS != null) {
			$row = $debitorRS->fetch_assoc();
			$weight = $row['select_weight'] + 1;
			$sql = "update debitor set select_weight = {$weight} and active = 1 where id = {$row['id']}";
			$this->db->query($sql);
			$newID = $row['id'];
		} else {
			$sql = "insert into debitor (name, group_id, select_weight, active) values ('{$name}', {$groupID}, 0, 1)";
			$this->db->query($sql);
			$newID = $this->db->insert_id;
		}

		return $newID;
	}

	public function updateDebitor($groupID, $debitorID, $name) {
		$sql = "update debitor set name = '{$name}' where group_id = {$groupID} and id = {$debitorID}";
		$rs = $this->db->query($sql);

		return $rs;
	}

	public function deleteDebitor($groupID, $debitorID) {
		$sql = "update debitor set active = 0, select_weight = 0 where group_id = {$groupID} and id = {$debitorID}";
		return $this->db->query($sql);
	}

	/*************************
		Schedule functions
	**************************/

	public function addSchedule($groupID, $userID, $accountID, $categoryID, $debitorID, $amount, $transactionTypeID, $scheduleTypeID, $unit, $step, $dayOfWeek) {

	}

	/*******************************
		Schedule Type functions
	********************************/

	public function getScheduleTypesForGroup($groupID) {
		$sql = "select * from schedule_type where group_id = {$groupID}";
		$rs = $this->db->query($sql);

		if ($rs->num_rows > 0) {
			return $rs;
		}

		return;	
	}
}

?>











