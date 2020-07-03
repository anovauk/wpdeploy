<?php

use Phalcon\Mvc\Model;

class PluginPackage extends Model {

	protected $id;
	protected $display_name;

	public function initialize() {

		// Set the source table
		$this->setSource('Plugin_Package');

        // Setup 1 to n relationships
        $this->hasMany(
            'id',
            'PluginPackageWordPressPluginRel',
            'plugin_package_id'
        );
	}

	public function getId() {
		return $this->id;
	}

	public function getDisplayName() {
		return $this->display_name;
	}

	public function setDisplayName($display_name) {
		$this->display_name = $display_name;
		return $this;
	}
}