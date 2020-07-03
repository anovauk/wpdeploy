<?php
use Phalcon\Mvc\Model;

class Template extends Model {

	protected $id;
	protected $environment_id;
	protected $account_id;
	protected $label;

	public function initialize() {

		// Set the source table
		$this->setSource('Template');

        // Setup relationships
        $this->hasOne(
            'environment_id',
            'Environment',
            'id'
        );

        // Setup relationships
        $this->hasOne(
            'account_id',
            'Account',
            'id'
        );
	}

	public function getId() {
		return $this->id;
	}

	public function getEnvironmentId() {
		return $this->environment_id;
	}

	public function getAccountId() {
		return $this->account_id;
	}

	public function getLabel() {
		return $this->label;
	}

	public function setEnvironmentId($id) {
		$this->environment_id = $id;
		return $this;
	}

	public function setAccountId($id) {
		$this->account_id = $id;
		return $this;
	}

	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}

}