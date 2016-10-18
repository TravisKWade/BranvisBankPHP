<?php

class Debitor {
	public $debitorID;
	public $name = "";
	public $selectWeight;

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setDebitorID($arrayValues['id']);
		$this->setName($arrayValues['name']);
		$this->setSelectWeight($arrayValues['select_weight']);
	}

	/********************
		Setters
	*********************/
	public function setDebitorID($id) {
		$this->debitorID = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setSelectWeight($selectWeight) {
		$this->selectWeight = $selectWeight;
	}

	/********************
		Getters
	*********************/
	public function getDebitorID() {
		return $this->debitorID;
	}

	public function getName() {
		return $this->name;
	}

	public function getSelectWeight() {
		return $this->selectWeight;
	}

}

?>