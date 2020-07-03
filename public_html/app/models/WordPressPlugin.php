<?php

use Phalcon\Mvc\Model;

class WordPressPlugin extends Model {

	protected $id;
	protected $display_name;
	protected $wp_slug;

	public function initialize() {

		// Set the source table
		$this->setSource('WordPress_Plugin');

        // Setup 1 to n relationships
        $this->hasMany(
            'id',
            'PluginPackageWordPressPluginRel',
            'wordpress_plugin_id'
        );
	}

	public function getId() {
		return $this->id;
	}

	public function getDisplayName() {
		return $this->display_name;
	}

	public function getWPSlug() {
		return $this->wp_slug;
	}

	public function setDisplayName($display_name) {
		$this->display_name = $display_name;
		return $this;
	}

	public function setWPSlug($wp_slug) {
		$this->wp_slug = $wp_slug;
		return $this;
	}

}