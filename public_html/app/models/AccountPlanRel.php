<?php

use Phalcon\Mvc\Model;

class AccountPlanRel extends Model {

	protected $id;
	protected $account_id;
	protected $plan_id;

	public function initialize() {

		// Set the source table
		$this->setSource('Account_Plan_Rel');

		// Setup relationships
        $this->belongsTo('account_id', 'Account', 'id');
        $this->belongsTo('plan_id', 'Plan', 'id');

	}

	public function getId() {
		return $this->id;
	}

	public function getAccountId() {
		return $this->account_id;
	}

	public function getPlanId() {
		return $this->plan_id;
	}

	public function setAccountId($id) {
		$this->account_id = $id;
		return $this;
	}

	public function setPlanId($id) {
		$this->plan_id = $id;
		return $this;
	}

}