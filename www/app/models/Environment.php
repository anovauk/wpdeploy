<?php

use Phalcon\Mvc\Model;

class Environment extends Model {

	protected $id;
	protected $name;
	protected $domain_name;
	protected $dir_name;
	
	public function initialize() {
		// Set the source table
		$this->setSource('Environment');
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getDomainName() {
		return $this->domain_name;
	}

	public function getDirName() {
		return $this->dir_name;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function setDomainName($domain_name) {
		$this->domain_name = $domain_name;
		return $this;
	}

	public function setDirName($dir) {
		$this->dir_name = $dir;
		return $this;
	}

}