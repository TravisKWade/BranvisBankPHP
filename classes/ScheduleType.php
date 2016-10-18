<?php

class ScheduleType {
	public $scheduleTypeID;
	public $name;
	public $groupID;
	public $active;

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setScheduleTypeID($arrayValues['id']);
		$this->setActive($arrayValues['active']);
		$this->setGroupID($arrayValues['group_id']);
		$this->setName($arrayValues['name']);
	}

	/********************
		Setters
	*********************/
	public function setScheduleTypeID($id) {
		$this->scheduleID = $id;
	}

	public function setAccountID($id) {
		$this->accountID = $id;
	}

	public function setGroupID($id) {
		$this->groupID = $id;
	}

	public function setActive($active) {
		$this->active = $active;
	}

	public function setName($name) {
		$this->name = $name;
	}

	/********************
		Getters
	*********************/
	public function getScheduleTypeID() {
		return $this->scheduleID;
	}

	public function getAccountID() {
		return $this->accountID;
	}

	public function getGroupID() {
		return $this->groupID;
	}

	public function getActive() {
		return $this->active;
	}

	public function getName() {
		return $this->name;
	}
}

?>