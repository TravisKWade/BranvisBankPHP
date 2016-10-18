<?php

class Group {
	public $groupID;
	public $name = "";

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setGroupID($arrayValues['id']);
		$this->setName($arrayValues['name']);
	}

	/********************
		Setters
	*********************/
	public function setGroupID($id) {
		$this->groupID = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/********************
		Getters
	*********************/
	public function getGroupID() {
		return $this->groupID;
	}

	public function getName() {
		return $this->name;
	}

}

?>