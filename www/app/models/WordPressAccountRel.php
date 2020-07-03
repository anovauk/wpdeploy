<?php

use Phalcon\Mvc\Model;

class WordPressAccountRel extends Model {

	protected $id;
	protected $wordpress_id;
	protected $account_id;

	public function initialize() {

		// Set the source table
		$this->setSource('WordPress_Account_Rel');

		// Setup relationships
        $this->belongsTo('account_id', 'Account', 'id');
        $this->belongsTo('wordpress_id', 'WordPress', 'id');

	}

	public function getId() {
		return $this->id;
	}

	public function getAccountId() {
		return $this->account_id;
	}

	public function getWordPressId() {
		return $this->wordpress_id;
	}

	public function setAccountId($id) {
		$this->account_id = $id;
		return $this;
	}

	public function setWordPressId($id) {
		$this->wordpress_id = $id;
		return $this;
	}

}