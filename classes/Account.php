<?php

class Account {
	public $accountID;
	public $name = "";
	public $balance = 0.00;

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setAccountID($arrayValues['id']);
		$this->setName($arrayValues['name']);
		$this->setBalance($arrayValues['balance']);
	}

	/********************
		Setters
	*********************/
	public function setAccountID($id) {
		$this->accountID = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setBalance($balance) {
		$this->balance = $balance;
	}

	/********************
		Getters
	*********************/
	public function getAccountID() {
		return $this->accountID;
	}

	public function getName() {
		return $this->name;
	}

	public function getBalance(){
		return $this->balance;
	}

}

?>