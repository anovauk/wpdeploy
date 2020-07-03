<?php

// No Timeout
set_time_limit(0);

class WPDeploymentDaemon {

	var $host = null;
	var $port = null;
	var $socket = null;

	function __construct() {

	}

	/**
	 *	Get the Host
	 */
	public function getHost() {
		if (!is_null($this->host)) {
			return $this->host;
		} else {
			return false;
		}
	}

	/**
	 *	Get the Port
	 */
	public function getPort() {
		if (!is_null($this->port)) {
			return $this->port;
		} else {
			return false;
		}
	}

	/**
	 *	Set the Host
	 */
	public function setHost($host=null) {
		if (is_null($host)) {
			return false;
		} else {
			$this->host = $host;
			return $this;
		}
	}

	/**
	 *	Set the Port
	 */
	public function setPort($port=null) {
		if (is_null($port)) {
			return false;
		} else {
			$this->port = $port;
			return $this;
		}
	}

	/**
	 *	Connect to the server
	 */
	public function connect() {
		
		// Create socket
		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
		if (!$this->socket) {
			return false;
		}

		// Connect to server
		$result = socket_connect($this->socket, $this->getHost(), $this->getPort());
		if (!$result) {
			return false;
		}

		// Read welcome message
		$data = socket_read($this->socket, 8192, PHP_NORMAL_READ);
		$data = trim($data);

		// Return true
		return true;

	}

	/**
	 *	Disconnect from the server
	 */
	public function disconnect() {

		// Create the quit command
		$cmd['command'] = 'quit';

		// Turn into JSON
		$jsonCmd = json_encode($cmd)."\n";

		// Send to server
		socket_write($this->socket, $jsonCmd, strlen($jsonCmd));

		// Close the socket
		socket_close($this->socket);
		
		// Return true;
		return true;
	}

	/**
	 *	Function to ping the server and receive a response
	 */
	public function ping() {

		$this->sendCommand('ping');
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}

	}

	/**
	 *	Install Wordpress CLI
	 */
	public function installWPCLI($accountUser) {

		$this->sendCommand('installwpcli',[ 'username' => $accountUser]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}


	/**
	 *	Add entry to .htpasswd file
	 */
	public function addHTPassword($accountUser,$domain,$htusername,$htpasswd) {

		$this->sendCommand('addhtpasswd',[ 'username' => $accountUser, 'directory' => $domain, 'htAccessUser' => $htusername, 'htAccessPass' => $htpasswd]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	/**
	 *	Change the usernames password
	 */
	public function changeHTPassword($accountUser,$domain,$htusername,$htpasswd) {

		$this->sendCommand('changehtpasswd',[ 'username' => $accountUser, 'directory' => $domain, 'htAccessUser' => $htusername, 'htAccessPass' => $htpasswd]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	/**
	 *	Delete the username from the .htpasswd file
	 */
	public function deleteHTPassword($accountUser,$domain,$htusername) {

		$this->sendCommand('deletehtpasswd',[ 'username' => $accountUser, 'directory' => $domain, 'htAccessUser' => $htusername]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	/**
	 *	List all users in the .htpasswd file
	 */
	public function listHTPassword($accountUser,$domain) {

		$this->sendCommand('listhtpasswd',[ 'username' => $accountUser, 'directory' => $domain]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	public function createHTaccess($accountUser,$domain,$authname) {

		$this->sendCommand('createhtaccess',[ 'username' => $accountUser, 'directory' => $domain, 'authname' => $authname]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	public function disableHTAccess($accountUser,$domain) {

		$this->sendCommand('disablehtaccess',[ 'username' => $accountUser, 'directory' => $domain]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	public function createWordpressInstall($user,$directory,$dbuser,$dbpass,$db,$siteurl,$sitetitle,$adminuser,$adminpass,$adminemail) {

		$this->sendCommand('createwordpress',[ 	'user' => $user, 'directory' => $directory, 'dbuser' => $dbuser,
												'dbpass' => $dbpass, 'db' => $db, 'siteurl' => $siteurl,
												'sitetitle' => $sitetitle,  'adminuser' => $adminuser,
												'adminpass' => $adminpass, 'adminemail' => $adminemail]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	public function duplicateWordpressInstall($username, $srcDir, $dstDir, $newURL) {

		$this->sendCommand('duplicatewordpress',[ 	'username' => $username, 'srcDir' => $srcDir, 'dstDir' => $dstDir,
													'newURL' => $newURL]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	public function duplicateWordpressTemplate($srcUsername, $dstUsername, $srcDir, $dstDir, $newURL) {

		$this->sendCommand('duplicatewordpresstemplate',[ 	
			'srcUsername' => $srcUsername,
			'dstUsername' => $dstUsername,
			'srcDir' => $srcDir, 
			'dstDir' => $dstDir,
			'newURL' => $newURL
		]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	public function doesHTAccessExist($usename,$domain) {

		$this->sendCommand('doeshtaccessexist',[ 'username' => $usename, 'directory' => $domain ]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			if ($result['resultData'] === 0) {
				// Wordpress not installed
				return false;
			} elseif ($result['resultData'] === 1) {
				// Wordpress is installed
				return true;
			}
		} else {
			return false;
		}
	}

	public function isWordPressInstalled($usename,$directory) {

		$this->sendCommand('iswordpressinstalled',[ 'username' => $usename, 'directory' => $directory ]);
		$result = $this->readResult();
		if (isset($result['result']) && $result['result'] == "success") {
			if ($result['resultData'] === 0) {
				// Wordpress not installed
				return false;
			} elseif ($result['resultData'] === 1) {
				// Wordpress is installed
				return true;
			}
		} else {
			return false;
		}
	}

	public function installWordpressThemes($user,$directory,$themes=[]) {

		$this->sendCommand('installwordpressthemes', [
			'user' => $user,
			'directory' => $directory,
			'themes' => $themes,
		]);

		$result = $this->readResult();
		if (isset($result['result']) == "success") {
			return $result['resultData'];
		} else {
			return false;
		}
	}

	public function activateWordpressTheme($user,$directory,$theme) {

		$this->sendCommand('activatewordpresstheme', [
			'user' => $user,
			'directory' => $directory,
			'theme' => $theme,
		]);

		$result = $this->readResult();
		if (isset($result['result']) == "success") {
			return $result['resultData'];
		} else {
			return false;
		}

	}

	public function installWordpressPlugins($user,$directory,$plugins=[]) {

		$this->sendCommand('installwordpressplugins', [
			'user' => $user,
			'directory' => $directory,
			'plugins' => $plugins
		]);

		$result = $this->readResult();
		if (isset($result['result']) == "success") {
			return $result['resultData'];
		} else {
			return false;
		}

	}

	/**
	 *	PRIVATE FUNCTIONS
	 */

	private function sendCommand($command,$params=[]) {
		
		// Set the command to execute on the server
		$cmd['command'] = $command;

		// If we have params, send them as well
		if (!empty($params)) {
			$cmd['params'] = $params;	
		}

		// Turn into JSON
		$jsonCmd = json_encode($cmd)."\n";

		// Send to server
		socket_write($this->socket, $jsonCmd, strlen($jsonCmd));
		
	}

	private function readResult() {
		
		// Read data from the socket
		$data = socket_read($this->socket, 8192, PHP_NORMAL_READ);
		$data = trim($data);

		// Decode data
		$tmpArray = json_decode($data,TRUE);

		// Return array to calling function
		return $tmpArray;
	}
}

?>