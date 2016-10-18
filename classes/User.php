<?php

class User {
	public $userID;
	public $email;

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setUserID($arrayValues['id']);
		$this->setEmail($arrayValues['email']);
	}

	/********************
		Setters
	*********************/
	public function setUserID($id) {
		$this->userID = $id;
	}

	public function setEmail($email) {
		$this->email = $email;
	}
	/********************
		Getters
	*********************/
	public function getUserID() {
		return $this->userID;
	}

	public function getEmail() {
		return $this->email;
	}

}

?>