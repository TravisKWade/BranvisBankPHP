<?php

class Category {
	public $categoryID;
	public $name = "";

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setCategoryID($arrayValues['id']);
		$this->setName($arrayValues['name']);
	}

	/********************
		Setters
	*********************/
	public function setCategoryID($id) {
		$this->categoryID = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/********************
		Getters
	*********************/
	public function getCategoryID() {
		return $this->categoryID;
	}

	public function getName() {
		return $this->name;
	}

}

?>