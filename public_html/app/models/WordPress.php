<?php
use Phalcon\Mvc\Model;

class WordPress extends Model {

	protected $id;
	protected $environment_id;
	protected $wp_site_url;
	protected $wp_site_title;
	protected $wp_admin_user;
	protected $wp_admin_pass;
	protected $wp_admin_email;

	// Set the Dependency Injector
	protected $crypt;

	public function onConstruct() {
		// Grab the DI Object and ultimately the cryptology service
		$di = \Phalcon\DI::getDefault();
		$this->crypt = $di['crypt'];
	}

	public function initialize() {

		// Set the source table
		$this->setSource('WordPress');

		// Setup relationships
        $this->hasOne(
            'id',
            'WordPressAccountRel',
            'wordpress_id'
        );

        // Setup relationships
        $this->hasOne(
            'environment_id',
            'Environment',
            'id'
        );
	}

	public function getId() {
		return $this->id;
	}

	public function getEnvironmentId() {
		return $this->environment_id;
	}

	public function getWPSiteUrl() {
		return $this->wp_site_url;
	}

	public function getWPSiteTitle() {
		return $this->wp_site_title;
	}

	public function getWPAdminUsername() {
		return $this->wp_admin_user;
	}

	public function getWPAdminPassword() {
		if ($this->wp_admin_pass !== null) {
			return $this->crypt->decryptBase64($this->wp_admin_pass);
		} else {
			return $this->wp_admin_pass;
		}
	}

	public function getWPAdminEmail() {
		return $this->wp_admin_email;
	}

	public function setEnvironmentId($id) {
		$this->environment_id = $id;
		return $this;
	}

	public function setWPSiteUrl($url) {
		$this->wp_site_url = $url;
		return $this;
	}

	public function setWPSiteTitle($title) {
		$this->wp_site_title = $title;
		return $this;
	}

	public function setWPAdminUsername($username) {
		$this->wp_admin_user = $username;
		return $this;
	}

	public function setWPAdminPassword($password) {
		$this->wp_admin_pass = $this->crypt->encryptBase64($password);
		return $this;
	}

	public function setWPAdminEmail($email) {
		$this->wp_admin_email = $email;
		return $this;
	}

}