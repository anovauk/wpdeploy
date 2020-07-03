<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class ApiController extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {

    }

    public function addHTAccessUserAction() {

        // Disable view processing
        $this->view->disable();

         if ($this->request->isPost()) {

            // Get the required get vars
            $accountID = $this->request->getPost('account_id');
            $environmentID = $this->request->getPost('environment_id');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            // Get the account details
            $account = Account::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $accountID
                ]
            ]);

            if (!$account) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
                exit();
            }

            // Get the server details
            $server = $account->getAccountServerRel()->getServer();
            if (!$server) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
                exit();
            }

            // Lookup the environment information
            $environment = Environment::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $environmentID
                ]
            ]);

            if (!$environment) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment']);
                exit();
            }

            $wpDeployment = new WPDeploymentDaemon();
            // Set host and port
            $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
            // Connect to server
            if (!$wpDeployment->connect()) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
                exit();
            }

            $envDir = $environment->getDirName();
            $envDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envDir );
            $addHTPassword = $wpDeployment->addHTPassword($account->getHostUsername(), $envDir, $username, $password);

            // Print response string
            print json_encode(['status' => 'success', 'resultdata' => $addHTPassword ]);
            exit();
        }

    }

    public function disableHTAccessAction() {

        // Disable view processing
        $this->view->disable();

        // Get the required get vars
        $accountID = (int) $_GET['account_id'];
        $environmentID = (int) $_GET['environment_id'];

        // Get the account details
        $account = Account::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $accountID
            ]
        ]);

        if (!$account) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
            exit();
        }

        // Get the server details
        $server = $account->getAccountServerRel()->getServer();
        if (!$server) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
            exit();
        }

        // Lookup the environment information
        $environment = Environment::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $environmentID
            ]
        ]);

        if (!$environment) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment']);
            exit();
        }

        $wpDeployment = new WPDeploymentDaemon();
        // Set host and port
        $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
        // Connect to server
        if (!$wpDeployment->connect()) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
            exit();
        }

        $envDir = $environment->getDirName();
        $envDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envDir );
        $disableHTAccess = $wpDeployment->disableHTAccess($account->getHostUsername(), $envDir);

        // Print response string
        print json_encode(['status' => 'success', 'resultdata' => $disableHTAccess ]);
        exit();

    }

    public function enableHTAccessAction() {

        // Disable view processing
        $this->view->disable();

        // Get the required get vars
        $accountID = (int) $_GET['account_id'];
        $environmentID = (int) $_GET['environment_id'];

        // Get the account details
        $account = Account::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $accountID
            ]
        ]);

        if (!$account) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
            exit();
        }

        // Get the server details
        $server = $account->getAccountServerRel()->getServer();
        if (!$server) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
            exit();
        }

        // Lookup the environment information
        $environment = Environment::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $environmentID
            ]
        ]);

        if (!$environment) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment']);
            exit();
        }

        $wpDeployment = new WPDeploymentDaemon();
        // Set host and port
        $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
        // Connect to server
        if (!$wpDeployment->connect()) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
            exit();
        }

        $envDir = $environment->getDirName();
        $envDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envDir );
        $addHTAccess = $wpDeployment->createHTaccess($account->getHostUsername(), $envDir, 'Admin');

        // Print response string
        print json_encode(['status' => 'success', 'resultdata' => $addHTAccess ]);
        exit();

    }

    public function deleteHTAccessUserAction() {

        // Disable view processing
        $this->view->disable();

        // Get the required get vars
        $accountID = (int) $_GET['account_id'];
        $environmentID = (int) $_GET['environment_id'];
        $username = $_GET['username'];

        // Get the account details
        $account = Account::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $accountID
            ]
        ]);

        if (!$account) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
            exit();
        }

        // Get the server details
        $server = $account->getAccountServerRel()->getServer();
        if (!$server) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
            exit();
        }

        // Lookup the environment information
        $environment = Environment::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $environmentID
            ]
        ]);

        if (!$environment) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment']);
            exit();
        }

        $wpDeployment = new WPDeploymentDaemon();
        // Set host and port
        $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
        // Connect to server
        if (!$wpDeployment->connect()) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
            exit();
        }

        $envDir = $environment->getDirName();
        $envDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envDir );
        $addHTAccess = $wpDeployment->createHTaccess($account->getHostUsername(), $envDir, 'Admin');
        $userDeleted = $wpDeployment->deleteHTPassword($account->getHostUsername(), $envDir, $username);

        // Print response string
        print json_encode(['status' => 'success', 'resultdata' => $userDeleted ]);
        exit();

    }

     public function markAsTemplateAction() {

        // Disable view processing
        $this->view->disable();

         if ($this->request->isPost()) {

            // Get the required get vars
            $accountID = $this->request->getPost('account_id');
            $environmentID = $this->request->getPost('environment_id');
            $templateLabel = $this->request->getPost('templateLabel');

            // Get the account details
            $account = Account::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $accountID
                ]
            ]);

            if (!$account) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
                exit();
            }

            // See if the template already exists
            $template = Template::findFirst([
                'account_id = :account_id: AND environment_id = :environment_id:',
                'bind' => [
                    'account_id' => $accountID,
                    'environment_id' => $environmentID
                ]
            ]);

            if (!$template) {
                // No template exists, add it
                $newTemplate = new Template();
                $newTemplate->setEnvironmentId($environmentID)
                    ->setAccountId($accountID)
                    ->setLabel($templateLabel)
                    ->save();
            }

            // Print response string
            print json_encode(['status' => 'success', 'resultdata' => 'Template Saved' ]);
            exit();
        }
    }

    public function getEnvironmentAction() {

    	// Disable view processing
        $this->view->disable();

        // Get the required get vars
        $accountID = (int) $_GET['account_id'];
        $environmentID = (int) $_GET['environment_id'];

        // Get the account details
        $account = Account::findFirst([
        	"id = :id:",
        	"bind" => [
        		"id" => $accountID
        	]
        ]);
        if (!$account) {
        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
        	exit();
        }

        // Get the server details
        $server = $account->getAccountServerRel()->getServer();
        if (!$server) {
        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
        	exit();
        }

        // Lookup the environment information
        $environment = Environment::findFirst([
        	"id = :id:",
        	"bind" => [
        		"id" => $environmentID
        	]
        ]);
        if (!$environment) {
        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment']);
        	exit();
        }

        // See if a template exists for this environment
        $template = Template::findFirst([
            "environment_id = :environment_id: AND account_id = :account_id:",
            "bind" => [
                "environment_id" => $environmentID,
                "account_id" => $accountID
            ]
        ]);

        $wpDeployment = new WPDeploymentDaemon();
        // Set host and port
        $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
        // Connect to server
        if (!$wpDeployment->connect()) {
            print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
            exit();
        }

        // Execute the isWordPressInstalled function
        $envDir = $environment->getDirName();
        $envDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envDir );
        $wpInstalled = $wpDeployment->isWordPressInstalled($account->getHostUsername(), $envDir);
        $htaccessExist = $wpDeployment->doesHTAccessExist($account->getHostUsername(), $envDir);
        $users = $wpDeployment->listHTPassword($account->getHostUsername(), $envDir);
        
        // Send the quit command
        $wpDeployment->disconnect();
        $tmpArray = [];
        // Check results for wordpress check
        if ($wpInstalled === true) {
        	// Installed
            $tmpArray['wordpress'] = 1;
        } else {
        	// Not installed
            $tmpArray['wordpress'] = 0;
        }
        // Check results for htaccess check
        if ($htaccessExist === true) {
            // Exists
            $tmpArray['htaccess'] = 1;
            $tmpArray['htaccessData'] = $users;
        } else {
            // Does not exist
            $tmpArray['htaccess'] = 0;
        }
        if (!$template) {
            $tmpArray['template'] = 0;
        } else {
            $tmpArray['template'] = 1;
        }
        // Print response string
        print json_encode(['status' => 'success', 'resultdata' => $tmpArray]);

    }

    public function deployWordpressAction() {

    	// Disable view processing
        $this->view->disable();

        if ($this->request->isPost()) {

	        // Get the required get vars
	        $accountID = $this->request->getPost('account_id');
	        $environmentID = $this->request->getPost('environment_id');
	        $wpSiteTitle = $this->request->getPost('wpSiteTitle');
	        $wpAdminUser = $this->request->getPost('wpAdminUser');
	        $wpAdminPassword = $this->request->getPost('wpAdminPassword');
	        $wpAdminEmail = $this->request->getPost('wpAdminEmail');
            $pluginPackage = $this->request->getPost('pluginPackage');

	        // Get the account details
	        $account = Account::findFirst([
	        	"id = :id:",
	        	"bind" => [
	        		"id" => $accountID
	        	]
	        ]);
	        if (!$account) {
	        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
	        	exit();
	        }

	        // Get the server details
	        $server = $account->getAccountServerRel()->getServer();
	        if (!$server) {
	        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
	        	exit();
	        }

	        // Lookup the environment information
	        $environment = Environment::findFirst([
	        	"id = :id:",
	        	"bind" => [
	        		"id" => $environmentID
	        	]
	        ]);
	        if (!$environment) {
	        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment']);
	        	exit();
	        }

	        // Instantiate the WHM class
            $whm = new WHM();
            $whm->setWHMHostname($server->getHostName())
                ->setWHMPort($server->getWHMPort())
                ->setWHMUsername($server->getWHMUsername())
                ->setWHMAPIToken($server->getWHMAPIToken())
                ->init();

	        // Work out the folder and subdomain name
	        $envDir = $environment->getDirName();
        	$envDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envDir );
        	if ($envDir == "public_html") {
        		$envDomain = 'www.'.$account->getHostDomain();
        	} else {
        		$envDomain = $envDir;
        	}

	        // Work out if we need to deploy a subdomain for this user?
	        if ($environment->getDirName() != "public_html") {
	        	// Make sure we don't have a subdomain already deployed
	        	$listSubDomains = $whm->listSubDomains($account->getHostUsername());
	        	if (!in_array($envDir,$listSubDomains)) {
	        		// We need to create the subdomain
	        		$response = $whm->addSubDomain($account->getHostUsername(),$environment->getDomainName(),$account->getHostDomain(),$envDir);
	        	}
	        }

	        // Generate password
	        $mySQLPassword = $this->generateRandomAlphaNumeric(16);
	        // Generate DB and Username
	       	$mySQLDatabase = $account->getHostUsername()."_".$this->generateRandomAlpha(3);

	       	// Create database, user and assign privs
            try {
                $whm->createMySQLDatabase($account->getHostUsername(),$mySQLDatabase);
                $whm->createMySQLUsername($account->getHostUsername(),$mySQLDatabase,$mySQLPassword);
                $whm->assignMySQLPermissions($account->getHostUsername(),$mySQLDatabase,$mySQLDatabase);
            } catch (\Exception $e) {
                print json_encode(['status' => 'failure', 'error' => trim($e->getMessage())]);
                exit();
            }

	        $wpDeployment = new WPDeploymentDaemon();
	        // Set host and port
	        $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
	        // Connect to server
	        if (!$wpDeployment->connect()) {
	            print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
	            exit();
	        }

	        // Execute the wordpress installation routine
            $res = $wpDeployment->createWordpressInstall($account->getHostUsername(), $envDir, $mySQLDatabase, $mySQLPassword, $mySQLDatabase, 'https://'.$envDomain, $wpSiteTitle, $wpAdminUser, $wpAdminPassword, $wpAdminEmail);

            // Sleep for 45 seconds to allow time for the wordpress install create function to complete
            sleep(45);

            // Retrieve the package
            $pluginPackageObj = PluginPackage::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $pluginPackage
                ]
            ]);
            $pluginPackageRel = $pluginPackageObj->getPluginPackageWordPressPluginRel();
            foreach($pluginPackageRel as $wpPlugins) {
                $wpPluginList[] = $wpPlugins->getWordPressPlugin()->getWPSlug();
            }

            // Now install the plugins
            $res2 = $wpDeployment->installWordpressPlugins($account->getHostUsername(), $envDir, $wpPluginList);

            // Send the quit command
            $wpDeployment->disconnect();

            // See if sucessfully started installation
            if (!$res) {
                // It didn't
                print json_encode(['status' => 'failure', 'error' => 'Unable to install wordpress as requested']);
                exit();
            }

            // Lets's start the AutoSSL Check now so any required certificates can be generated
            $whm->startAutoSSLCheck($account->getHostUsername());

            // Signal success
            print json_encode(['status' => 'success', 'resultdata' => 'Successfully created new Wordpress Install']);
            exit();
	    }
    }

    public function syncWordpressAction() {

    	// Disable view processing
        $this->view->disable();

        if ($this->request->isPost()) {

	        // Get the required get vars
	        $accountID = $this->request->getPost('account_id');
	        $environmentID = $this->request->getPost('environment_id');
	        $syncWordpressTo = $this->request->getPost('syncWordpressToEnvironment');

	        // Get the account details
	        $account = Account::findFirst([
	        	"id = :id:",
	        	"bind" => [
	        		"id" => $accountID
	        	]
	        ]);
	        if (!$account) {
	        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
	        	exit();
	        }

	        // Get the server details
	        $server = $account->getAccountServerRel()->getServer();
	        if (!$server) {
	        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
	        	exit();
	        }

	        // Lookup the environment information to sync from
	        $environmentFrom = Environment::findFirst([
	        	"id = :id:",
	        	"bind" => [
	        		"id" => $environmentID
	        	]
	        ]);
	        if (!$environmentFrom) {
	        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment to sync from']);
	        	exit();
	        }

	        // Lookup the environment information to sync to
	        $environmentTo = Environment::findFirst([
	        	"id = :id:",
	        	"bind" => [
	        		"id" => $syncWordpressTo
	        	]
	        ]);
	        if (!$environmentTo) {
	        	print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment to sync to']);
	        	exit();
	        }

	        // Instantiate the WHM class
            $whm = new WHM();
            $whm->setWHMHostname($server->getHostName())
                ->setWHMPort($server->getWHMPort())
                ->setWHMUsername($server->getWHMUsername())
                ->setWHMAPIToken($server->getWHMAPIToken())
                ->init();

	        // Work out the folder and subdomain name
	        $envFromDir = $environmentFrom->getDirName();
	        $envFromDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envFromDir );
	        $envToDir = $environmentTo->getDirName();
        	$envToDir = preg_replace( '/{{domain}}/i', $account->getHostDomain(), $envToDir );
        	if ($envFromDir == "public_html") {
        		$envFromDomain = 'www.'.$account->getHostDomain();
        	} else {
        		$envFromDomain = $envFromDir;
        	}
        	if ($envToDir == "public_html") {
        		$envToDomain = 'www.'.$account->getHostDomain();
        	} else {
        		$envToDomain = $envToDir;
        	}

	        // Work out if we need to deploy a subdomain for this user?
	        if ($environmentTo->getDirName() != "public_html") {
	        	// Make sure we don't have a subdomain already deployed
	        	$listSubDomains = $whm->listSubDomains($account->getHostUsername());
	        	if (!in_array($envToDomain,$listSubDomains)) {
	        		// We need to create the subdomain
	        		$response = $whm->addSubDomain($account->getHostUsername(),$environmentTo->getDomainName(),$account->getHostDomain(),$envToDomain);
	        	}
	        }

	        $wpDeployment = new WPDeploymentDaemon();
	        // Set host and port
	        $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
	        // Connect to server
	        if (!$wpDeployment->connect()) {
	            print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
	            exit();
	        }

            // Install the Wordpress CLI
            $res = $wpDeployment->installWPCLI($account->getHostUsername());

            // Sleep for 10 seconds to give it time to download and install
            sleep(10);

	        // Execute the wordpress duplication routine
            $res = $wpDeployment->duplicateWordpressInstall($account->getHostUsername(), $envFromDir, $envToDir, 'https://'.$envToDomain);
            if (!$res) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to execute wordpress duplication command']);
                exit();
            }

            // Send the quit command
            $wpDeployment->disconnect();

             // Lets's start the AutoSSL Check now so any required certificates can be generated
            $whm->startAutoSSLCheck($account->getHostUsername());

            // Success
            print json_encode(['status' => 'success', 'resultdata' => 'Successfully Synced Wordpress Install']);
            exit();
            
	    }
    }

    public function importTemplateAction() {

        // Disable view processing
        $this->view->disable();

        if ($this->request->isPost()) {

            // Get the required get vars
            $accountID = $this->request->getPost('account_id');
            $environmentID = $this->request->getPost('environment_id');
            $templateID = $this->request->getPost('templateID');

            // Get the account from details
            $accountTo = Account::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $accountID
                ]
            ]);
            if (!$accountTo) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account']);
                exit();
            }

            // Get the server details
            $server = $accountTo->getAccountServerRel()->getServer();
            if (!$server) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified account\'s server']);
                exit();
            }

            // Lookup the environment information to sync from
            $environmentTo = Environment::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $environmentID
                ]
            ]);
            if (!$environmentTo) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment to sync from']);
                exit();
            }

            // Locate the specified template
            $template = Template::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $templateID
                ]
            ]);
            if (!$template) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified template to sync from']);
                exit();
            }

            $environmentIdFrom = $template->getEnvironmentId();
            $accountIdFrom = $template->getAccountId();

            // Get the account to details
            $accountFrom = Account::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $accountIdFrom
                ]
            ]);
            if (!$accountFrom) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate account to sync to']);
                exit();
            }

            // Lookup the environment information to sync to
            $environmentFrom = Environment::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $environmentIdFrom
                ]
            ]);
            if (!$environmentFrom) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to locate specified environment to sync to']);
                exit();
            }

            // Make sure that the sync from and to are on the same server, otherwise troubles
            // will happen
            if ($accountFrom->getAccountServerRel()->getServer()->getHostName() != $accountTo->getAccountServerRel()->getServer()->getHostName()) {
                // Not on the same server
                print json_encode(['status' => 'failure', 'error' => 'Unable to sync wordpress template - not on same server']);
                exit();
            }

            // Instantiate the WHM class
            $whm = new WHM();
            $whm->setWHMHostname($server->getHostName())
                ->setWHMPort($server->getWHMPort())
                ->setWHMUsername($server->getWHMUsername())
                ->setWHMAPIToken($server->getWHMAPIToken())
                ->init();

            // Work out the folder and subdomain name
            $envFromDir = $environmentFrom->getDirName();
            $envFromDir = preg_replace( '/{{domain}}/i', $accountFrom->getHostDomain(), $envFromDir );
            $envToDir = $environmentTo->getDirName();
            $envToDir = preg_replace( '/{{domain}}/i', $accountTo->getHostDomain(), $envToDir );
            if ($envFromDir == "public_html") {
                $envFromDomain = 'www.'.$accountFrom->getHostDomain();
            } else {
                $envFromDomain = $envFromDir;
            }
            if ($envToDir == "public_html") {
                $envToDomain = 'www.'.$accountTo->getHostDomain();
            } else {
                $envToDomain = $envToDir;
            }

            // Work out if we need to deploy a subdomain for this user?
            if ($environmentTo->getDirName() != "public_html") {
                // Make sure we don't have a subdomain already deployed
                $listSubDomains = $whm->listSubDomains($accountTo->getHostUsername());
                if (!in_array($envToDomain,$listSubDomains)) {
                    // We need to create the subdomain
                    $response = $whm->addSubDomain($accountTo->getHostUsername(),$environmentTo->getDomainName(),$accountTo->getHostDomain(),$envToDomain);
                }
            }

            $wpDeployment = new WPDeploymentDaemon();
            // Set host and port
            $wpDeployment->setHost($server->getWPDeploymentDaemonIP())->setPort($server->getWPDeploymentDaemonPort());
            // Connect to server
            if (!$wpDeployment->connect()) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to connect to the wpdeployment daemon']);
                exit();
            }

            // Install the Wordpress CLI
            $res = $wpDeployment->installWPCLI($accountTo->getHostUsername());

            // Sleep for 10 seconds to give it time to download and install
            sleep(10);

            // Execute the wordpress duplication routine
            $res = $wpDeployment->duplicateWordpressTemplate($accountFrom->getHostUsername(), $accountTo->getHostUsername(), $envFromDir, $envToDir, 'https://'.$envToDomain);
            if (!$res) {
                print json_encode(['status' => 'failure', 'error' => 'Unable to execute wordpress duplication command']);
                exit();
            }

            // Send the quit command
            $wpDeployment->disconnect();

             // Lets's start the AutoSSL Check now so any required certificates can be generated
            $whm->startAutoSSLCheck($accountTo->getHostUsername());

            // Success
            print json_encode(['status' => 'success', 'resultdata' => 'Successfully Synced Wordpress Install']);
            exit(); 
        }
    }

    private function generateRandomAlpha($numOfChars) {
    	$characters = 'abcdefghijklmnopqrstuvwxyz';
    	$randomString = '';
    	for ($i = 0; $i < $numOfChars; $i++) {
    		$index = rand(0, strlen($characters) - 1); 
        	$randomString .= $characters[$index]; 
    	}
    	return $randomString;
    }

    private function generateRandomAlphaNumeric($numOfChars) {
    	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    	$randomString = '';
    	for ($i = 0; $i < $numOfChars; $i++) {
    		$index = rand(0, strlen($characters) - 1); 
        	$randomString .= $characters[$index]; 
    	}
    	return $randomString;
    }

}