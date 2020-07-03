<?php

// Import the WHM API
use Gufy\CpanelPhp\Cpanel;

class WHM {

	var $whmUsername = null;
	var $whmAPIToken = null;
	var $whmHostname = null;
	var $whmPort = null;
	var $handle = null;

	public function __construct() {

	}

	/**
	 *	Getter and Setter Functions
	 */
	public function getWHMUsername() {
		if (!is_null($this->whmUsername)) {
			return $this->whmUsername;
		}
	}

	public function getWHMAPIToken() {
		if (!is_null($this->whmAPIToken)) {
			return $this->whmAPIToken;
		}
	}

	public function getWHMHostname() {
		if (!is_null($this->whmHostname)) {
			return $this->whmHostname;
		}
	}

	public function getWHMPort() {
		if (!is_null($this->whmPort)) {
			return $this->whmPort;
		}
	}

	public function setWHMUsername($username=null) {
		
		if (is_null($username)) {
			throw new \Exception("WHM Username cannot be blank");
		}

		$this->whmUsername = $username;
		return $this;
	}

	public function setWHMApiToken($token=null) {

		if (is_null($token)) {
			throw new \Exception("WHM API Token cannot be blank");
		}

		$this->whmAPIToken = $token;
		return $this;
	}

	public function setWHMHostname($hostname=null) {

		if (is_null($hostname)) {
			throw new \Exception("WHM Hostname cannot be blank");
		}

		$this->whmHostname = $hostname;
		return $this;
	}

	public function setWHMPort($port=null) {

		if (is_null($port)) {
			throw new \Exception("WHM Port cannot be blank");
		}

		$this->whmPort = $port;
		return $this;
	}

	public function init() {
		$this->handle = new \Gufy\CpanelPhp\Cpanel([
      		'host'        =>  'https://'.$this->getWHMHostname() . ":" . $this->getWHMPort(),
      		'username'    =>  $this->getWHMUsername(),
      		'auth_type'   =>  'hash',
      		'password'    =>  $this->getWHMAPIToken(),
  		]);

		// Set the Timeouts for the API to 60 seconds for both
		// connection timeout and timeout
		$this->handle->setTimeout(60);
		$this->handle->setConnectionTimeout(60);
	}

	public function modifyAccount($existingUsername,$newUsername=null,$newDomain=null) {

		// Create the options for the account
		$opts['user'] = $existingUsername;
		if (!is_null($newUsername)) {
			$opts['newuser'] = $newUsername;
		}
		if (!is_null($newDomain)) {
			$opts['DNS'] = $newDomain;
		}

		$modifyAccountResponse = $this->handle->modifyacct($opts);
		$modifyAccountInfo = json_decode($modifyAccountResponse);
		if (isset($modifyAccountInfo->status) && $modifyAccountInfo->status == 0) {
			throw new \Exception("Unable to modify account on server server");
		} elseif (isset($modifyAccountInfo->status) && $modifyAccountInfo->status == 1) {
			return $modifyAccountInfo;
		}
	}

	public function changePassword($username,$password) {

		$changePasswordResponse = $this->handle->passwd(['user' => $username, 'pass' => $password]);
		$changePasswordInfo = json_decode($changePasswordResponse);
		if (isset($changePasswordInfo->passwd[0]->status) && $changePasswordInfo->passwd[0]->status == 0) {
			throw new \Exception($changePasswordInfo->passwd[0]->statusmsg);
		} elseif (isset($changePasswordInfo->passwd[0]->status) && $changePasswordInfo->passwd[0]->status == 1) {
			return $changePasswordInfo;
		}
	}

	public function listAccount($username) {

		$accountResponse = $this->handle->accountsummary(['user' => $username]);
		$accountInfo = json_decode($accountResponse);
		if (isset($accountInfo->status) && $accountInfo->status == 0) {
			throw new \Exception("Unable to retrieve account from server");
		} elseif (isset($accountInfo->status) && $accountInfo->status == 1) {
			return $accountInfo;
		}
	}

	public function listAccounts() {
		$accountsResponse = $this->handle->listaccts();
		$accounts = json_decode($accountsResponse);
		if (isset($accounts->status) && $accounts->status == 0) {
			throw new \Exception("Unable to retrieve list of accounts from server");
		} elseif (isset($accounts->status) && $accounts->status == 1) {
			return $accounts;
		}
	}

	public function createAccount($domain,$username,$password,$plan) {
		$createResponse = $this->handle->createAccount($domain,$username,$password,$plan);
		$create = json_decode($createResponse);
		if (isset($create->result[0]) && $create->result[0]->status == 0) {
			// Failed to add domain
			throw new \Exception("Unable to add domain to cpanel server. Reason: ".$create->result[0]->statusmsg);
		} elseif (isset($create->result[0]) && $create->result[0]->status == 1) {
			// We added domain successfully
			return $create;
		}
	}

	public function removeAccount($username) {
		$deleteResponse = $this->handle->removeacct(['user' => $username]);
		$delete = json_decode($deleteResponse);
		if (isset($delete->result[0]) && $delete->result[0]->status == 0) {
			// Failed to add domain
			throw new \Exception("Unable to delete domain from cpanel server. Reason: ".$delete->result[0]->statusmsg);
		} elseif (isset($delete->result[0]) && $delete->result[0]->status == 1) {
			// We added domain successfully
			return $delete;
		}
	}

	public function addSubDomain($username,$subdomain,$domain,$directory) {
		$addSubDomainParams = [
			'domain' => $subdomain,
			'rootdomain' => $domain,
			'dir' => $directory
		];
		$addSubDomainResponse = $this->handle->cpanel('SubDomain','addsubdomain',$username,$addSubDomainParams);
		$addSubDomain = json_decode($addSubDomainResponse);
		if (isset($addSubDomain->data) && $addSubDomain->data->result == 0) {
			throw new \Exception("Unable to create subdomain: ".$addSubDomain->data->reason);
		} elseif (isset($addSubDomain->cpanelresult->data) && $addSubDomain->cpanelresult->data[0]->result == 0) {
			throw new \Exception("Unable to create subdomain: ".$addSubDomain->cpanelresult->data[0]->reason);
		} elseif (isset($addSubDomain->cpanelresult->data) && $addSubDomain->cpanelresult->data[0]->result == 1) {
			return $addSubDomain;
		}
	}

	public function listSubDomains($username) {
		$listSubDomainResponse = $this->handle->execute_action('3','DomainInfo','list_domains',$username);
		$listSubDomain = json_decode($listSubDomainResponse);

		if (isset($listSubDomain->result) && $listSubDomain->result->status == 0) {
			throw new \Exception("Unable to list subdomains: ".$listSubDomain->data->reason);
		} elseif (isset($listSubDomain->result->data->sub_domains) && $listSubDomain->result->status == 1) {
			return $listSubDomain->result->data->sub_domains;
		}
	}

	public function checkAutoSSLEnabled($username) {
		$checkAutoSSLEnabledResponse = $this->handle->execute_action('3','SSL','get_autossl_excluded_domains',$username);
		$checkAutoSSLEnabled = json_decode($checkAutoSSLEnabledResponse);
		if (isset($checkAutoSSLEnabled->result) && $checkAutoSSLEnabled->result->status == 0) {
			return FALSE;
		} elseif (isset($checkAutoSSLEnabled->result) && $checkAutoSSLEnabled->result->status == 1) {
			return TRUE;
		}
	}

	public function startAutoSSLCheck($username) {
		$startAutoSSLCheckResponse = $this->handle->execute_action('3','SSL','start_autossl_check',$username);
		$startAutoSSLCheck = json_decode($startAutoSSLCheckResponse);
		if (isset($startAutoSSLCheck->result) && $startAutoSSLCheck->result->status == 0) {
			return FALSE;
		} elseif (isset($startAutoSSLCheck->result) && $startAutoSSLCheck->result->status == 1) {
			return TRUE;
		}
	}

	public function createMySQLDatabase($username,$databaseName) {
		$createDatabaseResponse = $this->handle->execute_action('3','Mysql','create_database',$username,['name' => $databaseName]);
		$createDatabase = json_decode($createDatabaseResponse);
		if (isset($createDatabase->result) && $createDatabase->result->status == 0) {
			return FALSE;
		} elseif (isset($createDatabase->result) && $createDatabase->result->status == 1) {
			return TRUE;
		}
	}

	public function createMySQLUsername($username,$databaseUsername,$databasePassword) {
		$createUsernameResponse = $this->handle->execute_action('3','Mysql','create_user',$username,['name' => $databaseUsername,'password' => $databasePassword]);
		$createUsername = json_decode($createUsernameResponse);
		if (isset($createUsername->result) && $createUsername->result->status == 0) {
			return FALSE;
		} elseif (isset($createUsername->result) && $createUsername->result->status == 1) {
			return TRUE;
		}
	}

	public function assignMySQLPermissions($username,$databaseUsername,$databaseName,$privileges='ALL') {
		$assignMySQLPermissionsResponse = $this->handle->execute_action('3','Mysql','set_privileges_on_database',$username,['user' => $databaseUsername,'database' => $databaseName, 'privileges' => $privileges]);
		$assignMySQLPermissions = json_decode($assignMySQLPermissionsResponse);
		if (isset($assignMySQLPermissions->result) && $assignMySQLPermissions->result->status == 0) {
			return FALSE;
		} elseif (isset($assignMySQLPermissions->result) && $assignMySQLPermissions->result->status == 1) {
			return TRUE;
		}
	}
}

?>