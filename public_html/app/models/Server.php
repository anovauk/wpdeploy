<?php

use Phalcon\Mvc\Model;

class Server extends Model {

	protected $id;
	protected $server_name;
	protected $host_name;
	protected $whm_port;
	protected $whm_username;
	protected $whm_apitoken;
	protected $wpdeployment_daemon_ip;
	protected $wpdeployment_daemon_port;

	/**
     * This function is called only once every application initialisation
     */
    public function initialize() {

        // Set the source table
        $this->setSource('Server');

        // Setup relationships
        $this->hasMany(
            'id',
            'AccountServerRel',
            'server_id'
        );
    }

    public function getID() {
    	return $this->id;
    }

    public function getServerName() {
    	return $this->server_name;
    }

    public function getHostName() {
    	return $this->host_name;
    }

    public function getWHMPort() {
    	return $this->whm_port;
    }

    public function getWHMUsername() {
    	return $this->whm_username;
    }

    public function getWHMAPIToken() {
    	return $this->whm_apitoken;
    }

    public function getWPDeploymentDaemonIP() {
    	return $this->wpdeployment_daemon_ip;
    }

    public function getWPDeploymentDaemonPort() {
    	return $this->wpdeployment_daemon_port;
    }

    public function setServerName($server_name) {
    	$this->server_name = $server_name;
    	return $this;
    }

    public function setHostName($host_name) {
    	$this->host_name = $host_name;
    	return $this;
    }

    public function setWHMPort($whm_port) {
    	$this->whm_port = $whm_port;
    	return $this;
    }

    public function setWHMUsername($whm_username) {
    	$this->whm_username = $whm_username;
    	return $this;
    }

    public function setWHMAPIToken($whm_apitoken) {
    	$this->whm_apitoken = $whm_apitoken;
    	return $this;
    }

    public function setWPDeploymentDaemonIP($wpdeployment_daemon_ip) {
    	$this->wpdeployment_daemon_ip = $wpdeployment_daemon_ip;
    	return $this;
    }

    public function setWPDeploymentDaemonPort($wpdeployment_daemon_port) {
    	$this->wpdeployment_daemon_port = $wpdeployment_daemon_port;
    	return $this;
    }
}