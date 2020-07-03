<?php

use Phalcon\Mvc\Model;

class PluginPackageWordPressPluginRel extends Model {

	protected $id;
	protected $plugin_package_id;
	protected $wordpress_plugin_id;

	public function initialize() {

		// Set the source table
		$this->setSource('Plugin_Package_WordPress_Plugin_Rel');

		// Setup relationships
        $this->belongsTo('plugin_package_id', 'PluginPackage', 'id');
        $this->belongsTo('wordpress_plugin_id', 'WordPressPlugin', 'id');

	}

	public function getId() {
		return $this->id;
	}

	public function getPluginPackageId() {
		return $this->plugin_package_id;
	}

	public function getWordPressPluginId() {
		return $this->wordpress_plugin_id;
	}

	public function setPluginPackageId($id) {
		$this->plugin_package_id = $id;
		return $this;
	}

	public function setWordPressPluginId($id) {
		$this->wordpress_plugin_id = $id;
		return $this;
	}

}