<?php

class Transaction {
	public $transactionID;
	public $categroyID;
	public $debitorID;
	public $accountID;
	public $date;
	public $transactionTypeID;
	public $amount;
	public $reconciled;
	public $active;

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setTransactionID($arrayValues['id']);
		$this->setAccountID($arrayValues['account_id']);
		$this->setCategoryID($arrayValues['category_id']);
		$this->setAmount($arrayValues['amount']);
		$this->setDebitorID($arrayValues['debitor_id']);
		$this->setDate($arrayValues['date']);
		$this->setTransactionTypeID($arrayValues['transaction_type_id']);
		$this->setReconciled($arrayValues['reconciled']);
		$this->setActive($arrayValues['active']);
	}

	/********************
		Setters
	*********************/
	public function setTransactionID($id) {
		$this->transactionID = $id;
	}

	public function setAccountID($id) {
		$this->accountID = $id;
	}

	public function setCategoryID($id) {
		$this->categroyID = $id;
	}

	public function setDebitorID($id) {
		$this->debitorID = $id;
	}

	public function setTransactionTypeID($id) {
		$this->transactionTypeID = $id;
	}

	public function setDate($date) {
		// TODO: convert date without timestamp
		$this->date = $date;
	}

	public function setAmount($amount) {
		$this->amount = $amount;
	}

	public function setReconciled($reconciled) {
		$this->reconciled = $reconciled;
	}

	public function setActive($active) {
		$this->active = $active;
	}

	/********************
		Getters
	*********************/
	public function getTransactionID() {
		return $this->transactionID;
	}

	public function getAccountID() {
		return $this->accountID;
	}

	public function getCategoryID() {
		return $this->categroyID;
	}

	public function getDebitorID() {
		return $this->debitorID;
	}

	public function getTransactionTypeID() {
		return $this->transactionTypeID;
	}

	public function getDate() {
		return $this->date;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function getReconciled(){
		return $this->reconciled;
	}

	public function getActive(){
		return $this->active;
	}

}

?>