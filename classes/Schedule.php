<?php

class Schedule {
	public $scheduleID;
	public $scheduleTypeID;
	public $categroyID;
	public $debitorID;
	public $accountID;
	public $groupID;
	public $transactionTypeID;
	public $amount;
	public $active;
	public $unit;
	public $step;
	public $dayOfWeek;

	/********************
		Constructor
	*********************/
	public function __construct($arrayValues) {
		$this->setScheduleID($arrayValues['id']);
		$this->setScheduleID($arrayValues['schedule_type_id']);
		$this->setAccountID($arrayValues['account_id']);
		$this->setGroupID($arrayValues['group_id']);
		$this->setCategoryID($arrayValues['category_id']);
		$this->setAmount($arrayValues['amount']);
		$this->setDebitorID($arrayValues['debitor_id']);
		$this->setTransactionTypeID($arrayValues['transaction_type_id']);
		$this->setActive($arrayValues['active']);
		$this->setStep($arrayValues['step']);
		$this->setUnit($arrayValues['unit']);
		$this->setDayOfWeek($arrayValues['day_of_week']);

		$this->calculateNext();
	}

	/********************
		Setters
	*********************/
	public function setScheduleID($id) {
		$this->scheduleID = $id;
	}

	public function setScheduleTypeID($id) {
		$this->scheduleTypeID = $id;
	}

	public function setAccountID($id) {
		$this->accountID = $id;
	}

	public function setGroupID($id) {
		$this->groupID = $id;
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

	public function setAmount($amount) {
		$this->amount = $amount;
	}

	public function setActive($active) {
		$this->active = $active;
	}

	public function setStep($step) {
		$this->step = $step;
	}

	public function setUnit($unit) {
		$this->unit = $unit;
	}

	public function setDayOfWeek($dow) {
		$this->dayOfWeek = $dow;
	}

	/********************
		Getters
	*********************/
	public function getScheduleID() {
		return $this->scheduleID;
	}

	public function getScheduleTypeID() {
		return $this->scheduleTypeID;
	}

	public function getAccountID() {
		return $this->accountID;
	}

	public function getGroupID() {
		return $this->groupID;
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

	public function getAmount() {
		return $this->amount;
	}

	public function getStep() {
		return $this->step;
	}

	public function getUnit() {
		return $this->unit;
	}

	public function getActive() {
		return $this->active;
	}

	public function getDayOfWeek() {
		return $this->dayOfWeek;
	}

	/********************
		Functions
	*********************/

	public function calculateNext() {
		$dow   = 'saturday';
		$step  = 2;
		$unit  = 'W';

		$start = new DateTime('Y-m-d');
		$end   = clone $start;

		$start->modify($this->dayOfWeek); // Move to first occurence
		$end->add(new DateInterval('P1M')); // Move to 1 year from start

		$interval = new DateInterval("P{$this->step}{$this->unit}");
		$period   = new DatePeriod($start, $interval, $end);

		foreach ($period as $date) {
		    echo $date->format('D, d M Y'), PHP_EOL;
		}
	}
}

?>