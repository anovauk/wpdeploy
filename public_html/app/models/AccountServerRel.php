<?php

use Phalcon\Mvc\Model;

class AccountServerRel extends Model {

	protected $id;
	protected $account_id;
	protected $server_id;

	public function initialize() {

		// Set the source table
		$this->setSource('Account_Server_Rel');

		// Setup relationships
        $this->belongsTo('account_id', 'Account', 'id');
        $this->belongsTo('server_id', 'Server', 'id');

	}

	public function getId() {
		return $this->id;
	}

	public function getAccountId() {
		return $this->account_id;
	}

	public function getServerId() {
		return $this->server_id;
	}

	public function setAccountId($id) {
		$this->account_id = $id;
		return $this;
	}

	public function setServerId($id) {
		$this->server_id = $id;
		return $this;
	}

}