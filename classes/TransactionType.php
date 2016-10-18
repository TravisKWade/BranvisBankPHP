<?php

class TransactionType {
	public $typeID;
	public $name = "";
	public $isDebit;

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setTransactionTypeID($arrayValues['id']);
		$this->setName($arrayValues['name']);
		$this->setIsDebit($arrayValues['debit']);
	}

	/********************
		Setters
	*********************/
	public function setTransactionTypeID($id) {
		$this->typeID = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setIsDebit($isDebit) {
		$this->isDebit = $isDebit;
	}
	/********************
		Getters
	*********************/
	public function getTransactionTypeID() {
		return $this->typeID;
	}

	public function getName() {
		return $this->name;
	}

	public function getIsDebit() {
		return $this->isDebit;
	}

}

?>