<?php

use Phalcon\Mvc\Model;

class Account extends Model {

	protected $id;
	protected $host_username;
	protected $host_password;
	protected $host_domain;

	// Set the Dependency Injector
	protected $crypt;

	public function onConstruct() {
		// Grab the DI Object and ultimately the cryptology service
		$di = \Phalcon\DI::getDefault();
		$this->crypt = $di['crypt'];
	}

	public function initialize() {

		// Set the source table
		$this->setSource('Account');

		// Setup 1 to 1 relationships
        $this->hasOne(
            'id',
            'AccountServerRel',
            'account_id'
        );

        // Setup 1 to 1 relationships
        $this->hasOne(
            'id',
            'AccountPlanRel',
            'account_id'
        );

        // Setup 1 to n relationships
        $this->hasMany(
            'id',
            'WordPressAccountRel',
            'account_id'
        );
	}

	public function getId() {
		return $this->id;
	}

	public function getHostUsername() {
		return $this->host_username;
	}

	public function getHostPassword() {
		if ($this->host_password !== null) {
			return $this->crypt->decryptBase64($this->host_password);
		} else {
			return $this->host_password;
		}
	}

	public function getHostDomain() {
		return $this->host_domain;
	}

	public function setHostUsername($username) {
		$this->host_username = $username;
		return $this;
	}

	public function setHostPassword($password) {
		$this->host_password = $this->crypt->encryptBase64($password);
		return $this;
	}

	public function setHostDomain($domain) {
		$this->host_domain = $domain;
		return $this;
	}

}