<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class HomeController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('Application');
        parent::initialize();
    }

    public function indexAction() {

    }

    public function serverAction() {

    	// Get all servers
    	$servers = Server::find();

    	// Check for successMsg or errorMsg
        if ($this->session->get('successMsg')) {
            $this->view->successMsg = $this->session->get('successMsg');
            $this->session->remove('successMsg');
        }
        if ($this->session->get('errorMsg')) {
            $this->view->errorMsg = $this->session->get('errorMsg');
            $this->session->remove('errorMsg');
        }

        $this->view->servers = $servers;

    }

    public function addServerAction() {

    	if ($this->request->isPost()) {
    		// Get all the vars
    		$serverName = $this->request->getPost('serverName','string');
    		$hostName = $this->request->getPost('hostName','string');
    		$whmPort = $this->request->getPost('whmPort');
    		$whmUsername = $this->request->getPost('whmUsername','string');
    		$whmAPIToken = $this->request->getPost('whmAPIToken','string');
    		$wpDeploymentDaemonIP = $this->request->getPost('wpDeploymentDaemonIP');
    		$wpDeploymentDaemonPort = $this->request->getPost('wpDeploymentDaemonPort');

            // Check we got input
    		if (!$serverName || !$hostName || !$whmPort || !$whmUsername || 
    			!$whmAPIToken || !$wpDeploymentDaemonIP || !$wpDeploymentDaemonPort) {
    			$this->session->set('errorMsg',['Required inputs missing']);
    			$this->response->redirect('home/server');
    		} else {

    			// Create new server object
    			$server = new Server();

    			// Set all the server details
    			$server->setServerName($serverName)
    				->setHostName($hostName)
    				->setWHMPort($whmPort)
    				->setWHMUsername($whmUsername)
    				->setWHMAPIToken($whmAPIToken)
    				->setWPDeploymentDaemonIP($wpDeploymentDaemonIP)
    				->setWPDeploymentDaemonPort($wpDeploymentDaemonPort);

    			// Save the new server
    			if (!$server->save()) {
    				$this->session->set('errorMsg',['Unable to add new server to the database']);
    				$this->response->redirect('home/server');
    			} else {
    				$this->session->set('successMsg',['Successfully saved new server to the database']);
    				$this->response->redirect('home/server');
    			}
    		}
    	}
    }

    /**
     *  This function is used to edit a server already stored in the
     *  database
     */
    public function editServerAction() {

        if ($this->request->isPost()) {

            // Get all the vars
            $serverID = $this->request->getPost('serverID');
            $serverName = $this->request->getPost('serverName','string');
            $hostName = $this->request->getPost('hostName','string');
            $whmPort = $this->request->getPost('whmPort');
            $whmUsername = $this->request->getPost('whmUsername','string');
            $whmAPIToken = $this->request->getPost('whmAPIToken','string');
            $wpDeploymentDaemonIP = $this->request->getPost('wpDeploymentDaemonIP','ipv4');
            $wpDeploymentDaemonPort = $this->request->getPost('wpDeploymentDaemonPort');

            // Check we got input
            if (!$serverID || !$serverName || !$hostName || !$whmPort || !$whmUsername || 
                !$whmAPIToken || !$wpDeploymentDaemonIP || !$wpDeploymentDaemonPort) {
                $this->session->set('errorMsg',['Required inputs missing']);
                $this->response->redirect('home/server');
            } else {

                // Get the server from the database
                $server = Server::findFirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $serverID
                    ]
                ]);

                // Did we find the server
                if (!$server) {
                    // No server found by this id
                    $this->session->set('errorMsg',['No server found with this ID']);
                    $this->response->redirect('home/server');
                } else {

                    // Update the server details as posted
                    $server->setServerName($serverName)
                        ->setHostName($hostName)
                        ->setWHMPort($whmPort)
                        ->setWHMUsername($whmUsername)
                        ->setWHMAPIToken($whmAPIToken)
                        ->setWPDeploymentDaemonIP($wpDeploymentDaemonIP)
                        ->setWPDeploymentDaemonPort($wpDeploymentDaemonPort);

                    // Save the new server
                    if (!$server->save()) {
                        $this->session->set('errorMsg',['Unable to edit the server in the database']);
                        $this->response->redirect('home/server');
                    } else {
                        $this->session->set('successMsg',['Successfully updated server in the database']);
                        $this->response->redirect('home/server');
                    }
                }
            }
        } else {

            // Get the customer id
            $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

            // Get the server from the database
            $server = Server::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id
                ]
            ]);

            // Confirm we got a server from the database
            if (!$server) {
                $this->session->set('errorMsg',['Server ID not found in Database']);
                $this->response->redirect('home/server');
            } else {
                // Map the server to the view bag
                $this->view->server = $server;    
            }
        }
    }

    /**
     *  This function will delete a server from the database
     */
    public function deleteServerAction() {

        // Get the customer id
        $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

        // Confirm we have an id to use
        if (is_null($id)) {
            // Error
            $this->session->set('errorMsg', 'Unable to delete the server record');
            $this->response->redirect('home/server');
        }

        // Load the server record
        $server = Server::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $id
            ]
        ]);

        // Delete the server
        if ($server->delete()) {
            // Server successfully deleted
            $this->session->set('successMsg',['Successfully deleted server from database']);
            $this->response->redirect('home/server');
        } else {
            // Unable to delete server
            $this->session->set('errorMsg', 'Unable to delete the server record');
            $this->response->redirect('home/server');
        }
    }

    public function accountAction() {

        // Get all Accounts
        $accounts = Account::find();

        // Check for successMsg or errorMsg
        if ($this->session->get('successMsg')) {
            $this->view->successMsg = $this->session->get('successMsg');
            $this->session->remove('successMsg');
        }
        if ($this->session->get('errorMsg')) {
            $this->view->errorMsg = $this->session->get('errorMsg');
            $this->session->remove('errorMsg');
        }

        $this->view->accounts = $accounts;
    }

    public function addAccountAction() {
        
        if ($this->request->isPost()) {
            
            // Get all the vars
            $planID = $this->request->getPost('planID');
            $hostUsername = $this->request->getPost('hostUsername','string');
            $hostPassword = $this->request->getPost('hostPassword','string');
            $hostDomain = $this->request->getPost('hostDomain','string');

            // Assign them to the view incase we hit an error and need it corrected
            // So fields will be populated with the existing data
            $this->view->planID = $planID;
            $this->view->hostUsername = $hostUsername;
            $this->view->hostPassword = $hostPassword;
            $this->view->hostDomain = $hostDomain;

            // Check we got input
            if (!$hostUsername || !$hostPassword || !$hostDomain) {
                
                // Set error message
                $this->view->errorMsg = ['Required inputs missing'];
                
                // Return
                return;

            } else {

                /* First we need to create the WHM Account */

                $plan = Plan::findfirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $planID
                    ]
                ]);
                if (!$plan) {
                    $this->view->errorMsg = ['Unable to locate plan name for account creation'];
                    return;
                }

                // Find the least loaded server we have available
                $serverID =  $this->findLeastLoadedServer();

                // Retrieve the server details
                $server = Server::findFirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $serverID
                    ]
                ]);

                // Make sure we got a result
                if (!$server) {
                    $this->view->errorMsg = ['Unable to locate the destination server in database'];
                    return;
                }

                // Instantiate the WHM class
                $whm = new WHM();
                $whm->setWHMHostname($server->getHostName())
                    ->setWHMPort($server->getWHMPort())
                    ->setWHMUsername($server->getWHMUsername())
                    ->setWHMAPIToken($server->getWHMAPIToken())
                    ->init();

                try {
                    
                    // Create the cPanel account
                    $create = $whm->createAccount($hostDomain,$hostUsername,$hostPassword,$plan->getWHMPlanName());    

                    if (!$create) {
                        // Unable to create the account for whatever reason
                        $this->view->errorMsg = ['Unable to create cPanel account'];
                        return;
                    }

                } catch (\Exception $e) {
                    $this->view->errorMsg = [trim($e->getMessage())];
                    return;
                }

                // Create new account object
                $account = new Account();

                // Set all the account details
                $account->setHostUsername($hostUsername)
                    ->setHostPassword($hostPassword)
                    ->setHostDomain($hostDomain);

                // Save the new account
                if (!$account->save()) {
                    $this->session->set('errorMsg',['Unable to add new account to the database']);
                    $this->response->redirect('home/account');
                } else {
                    // Create a new account server relationship
                    $accountServerRel = new AccountServerRel();
                    $accountServerRel->setAccountId($account->getId())->setServerId($server->getId())->save();
                    $this->session->set('successMsg',['Successfully saved new account to the database']);
                    $this->response->redirect('home/account');
                }
            }
        }

        // Get a list of all the plans
        $plans = Plan::find();
        $this->view->plans = $plans;
    }

    public function editAccountAction() {

        if ($this->request->isPost()) {

            // Get all the vars
            $id = $this->request->getPost("id");
            $planID = $this->request->getPost('planID');
            $hostUsername = $this->request->getPost('hostUsername','string');
            $hostPassword = $this->request->getPost('hostPassword','string');
            $hostDomain = $this->request->getPost('hostDomain','string');

            // Check we got input
            if (!$id || !$planID || !$hostUsername || !$hostPassword || !$hostDomain) {
                $this->session->set('errorMsg',['Required inputs missing']);
                $this->response->redirect('home/account');
                return;
            } else {

                // Get the account from the database
                $account = Account::findFirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $id
                    ]
                ]);
                $this->view->account = $account;

                // Did we find the account
                if (!$account) {
                    // No server found by this id
                    $this->session->set('errorMsg',['No Account found with this ID']);
                    $this->response->redirect('home/account');
                    return;
                } else {

                    // Get plans from the database
                    $plans = Plan::find();
                    $this->view->plans = $plans;

                    // Get the server id for the account
                    $serverID = $account->getAccountServerRel()->getServer()->getID();

                    // Retrieve the server details
                    $server = Server::findFirst([
                        "id = :id:",
                        "bind" => [
                            "id" => $serverID
                        ]
                    ]);

                    // Make sure we got a result
                    if (!$server) {
                        $this->view->errorMsg = ['Unable to locate the destination server in database'];
                        return;
                    }

                    // Instantiate the WHM class
                    $whm = new WHM();
                    $whm->setWHMHostname($server->getHostName())
                        ->setWHMPort($server->getWHMPort())
                        ->setWHMUsername($server->getWHMUsername())
                        ->setWHMAPIToken($server->getWHMAPIToken())
                        ->init();

                    // See if we need to change the username or domain name
                    if ($account->getHostUsername() != $hostUsername || $account->getHostDomain() != $hostDomain) {

                        // Execute modifyacct function
                        try {

                            // Change the user and/or domain name
                            $response = $whm->modifyAccount($account->getHostUsername(),(($account->getHostUsername() != $hostUsername) ? $hostUsername : null),(($account->getHostDomain() != $hostDomain) ? $hostDomain : null));

                        } catch (\Exception $e) {
                            $this->view->errorMsg = [trim($e->getMessage())];
                            return;
                        }

                        // Save the updates
                        $account->setHostUsername($hostUsername)->setHostDomain($hostDomain);
                    }

                    // See if we need to change the password
                    if ($account->getHostPassword() != $hostPassword) {

                        // Execute password change
                        try {

                            // Execute password change
                            $response = $whm->changePassword($account->getHostUsername(),$hostPassword);

                        } catch (\Exception $e) {
                            $this->view->errorMsg = [trim($e->getMessage())];
                            return;
                        }

                        // Save the updates
                        $account->setHostPassword($hostPassword);
                    }

                    if (!$account->save()) {
                        $this->session->set('errorMsg',['Unable to update account in the database']);
                        $this->response->redirect('home/account');
                        return;
                    } else {
                        $this->session->set('successMsg',['Successfully updated the account']);
                        $this->response->redirect('home/account');
                        return;    
                    }
                }
            }

        } else {

            // Get the customer id
            $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

            // Get plans from the database
            $plans = Plan::find();
            $this->view->plans = $plans;

            // Get the account from the database
            $account = Account::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id
                ]
            ]);

            // Confirm we got a account from the database
            if (!$account) {
                // No account found by this id
                $this->session->set('errorMsg',['No Account found with this ID']);
                $this->response->redirect('home/account');
            } else {
                // Map the account to the view bag
                $this->view->account = $account;    
            }
        }
    }

    public function importAccountAction() {

        // Get a list of all the plans
        $plans = Plan::find();
        $this->view->plans = $plans;

        // Get a list of server details
        $servers = Server::find();
        $this->view->servers = $servers;

        if ($this->request->isPost()) {
            
            // Get all the vars
            $planID = $this->request->getPost('planID');
            $serverID = $this->request->getPost('serverID');
            $hostUsername = $this->request->getPost('hostUsername','string');
            $hostPassword = $this->request->getPost('hostPassword','string');
            $forcePasswdChange = $this->request->getPost('passwordChange');
            $generateRandomPass = $this->request->getPost('generateRandomPass');

            // Assign them to the view incase we hit an error and need it corrected
            // So fields will be populated with the existing data
            $this->view->planID = $planID;
            $this->view->serverID = $serverID;
            $this->view->hostUsername = $hostUsername;
            $this->view->hostPassword = $hostPassword;

            // Check we got input
            if (!$hostUsername) {
                
                // Set error message
                $this->view->errorMsg = ['Required inputs missing'];
                
                // Return
                return;

            } else {

                // Retrieve the server details
                $server = Server::findFirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $serverID
                    ]
                ]);

                // Make sure we got a result
                if (!$server) {
                    $this->view->errorMsg = ['Unable to locate the destination server in database'];
                    return;
                }

                $plan = Plan::findfirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $planID
                    ]
                ]);
                // Make sure we got a result
                if (!$plan) {
                    $this->view->errorMsg = ['Unable to locate plan name for account creation'];
                    return;
                }

                // Instantiate the WHM class
                $whm = new WHM();
                $whm->setWHMHostname($server->getHostName())
                    ->setWHMPort($server->getWHMPort())
                    ->setWHMUsername($server->getWHMUsername())
                    ->setWHMAPIToken($server->getWHMAPIToken())
                    ->init();

                try {

                    // Import the cPanel account
                    $import = $whm->listAccount($hostUsername);    

                    if (!$import) {
                        // Unable to import the account for whatever reason
                        $this->view->errorMsg = ['Unable to import cPanel account'];
                        return;
                    } else {
                        $hostDomain = $import->acct[0]->domain;
                    }
                    
                    if (!is_null($forcePasswdChange)) {
                        // We need to force reset the password of the account

                        if (!is_null($generateRandomPass)) {
                            // We need to generate a random password
                            // Generate a new password
                            $hostPassword = $this->generateRandomAlphaNumeric(16);    
                        }

                        // Update the password on the server
                        $changePass = $whm->changePassword($hostUsername,$hostPassword);

                        // Confirm we have data
                        if (!$changePass) {
                            // Unable to change the password
                            $this->view->errorMsg = ['Unable to change the password on the account'];
                            return;
                        }
                    }

                } catch (\Exception $e) {
                    $this->view->errorMsg = [trim($e->getMessage())];
                    return;
                }

                // Create new account object
                $account = new Account();

                // Set all the account details
                $account->setHostUsername($hostUsername)
                    ->setHostPassword($hostPassword)
                    ->setHostDomain($hostDomain);

                // Save the new account
                if (!$account->save()) {
                    $this->session->set('errorMsg',['Unable to add new account to the database']);
                    $this->response->redirect('home/account');
                } else {
                    // Create a new account server relationship
                    $accountServerRel = new AccountServerRel();
                    $accountServerRel->setAccountId($account->getId())->setServerId($server->getId())->save();
                    $this->session->set('successMsg',['Successfully saved new account to the database']);
                    $this->response->redirect('home/account');
                }
            }
        }
    }

    /**
     *  This function will delete a account from the server and system
     */
    public function deleteAccountAction() {

        if ($this->request->isPost()) {

            // Get all the vars
            $id = $this->request->getPost('id');
            $skipDeleteServer = $this->request->getPost('skipDeleteServer');

            // Load the account record
            $account = Account::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id
                ]
            ]);

            if (!$account) {
                $this->session->set('errorMsg', ['Unable to delete the account record']);
                $this->response->redirect('home/account');
                return;
            }

            // Get the Account Server Relation
            $accountServerRel = $account->getAccountServerRel();
            if (!$accountServerRel)  {
                $this->session->set('errorMsg', ['Unable to delete the account record']);
                $this->response->redirect('home/account');
                return;
            }

            if (is_null($skipDeleteServer)) {

                // Get the server id
                $serverID = $accountServerRel->getServer()->getId();

                // Make sure we got data
                if (!$serverID) {
                    $this->session->set('errorMsg', ['Unable to delete the account record']);
                    $this->response->redirect('home/account');
                    return;
                }

                // Load the server record
                $server = Server::findFirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $serverID
                    ]
                ]);

                // Make sure we got data
                if (!$server) {
                    $this->session->set('errorMsg', ['Unable to delete the account record']);
                    $this->response->redirect('home/account');
                    return;
                }

                // Remove the account from the server

                // Instantiate the WHM class
                $whm = new WHM();
                $whm->setWHMHostname($server->getHostName())
                    ->setWHMPort($server->getWHMPort())
                    ->setWHMUsername($server->getWHMUsername())
                    ->setWHMAPIToken($server->getWHMAPIToken())
                    ->init();

                // Delete the account from the server
                try {

                    // Delete the account
                    $res = $whm->removeAccount($account->getHostUsername());    

                } catch (\Exception $e) {
                    // Error
                    $this->session->set('errorMsg', ['Unable to delete the account record '.trim($e->getMessage())]);
                    $this->response->redirect('home/account');
                    return;
                }

            }

            // Delete the relationship
            $account->getAccountServerRel()->delete();

            // Delete the account
            if ($account->delete()) {
                // Account successfully deleted
                $this->session->set('successMsg',['Successfully deleted account from database']);
                $this->response->redirect('home/account');
            } else {
                // Unable to delete account
                $this->session->set('errorMsg', ['Unable to delete the account record']);
                $this->response->redirect('home/account');
            }


        } else {

            // Get the account id
            $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;
            $this->view->id = $id;

            // Confirm we have an id to use
            if (is_null($id)) {
                // Error
                $this->session->set('errorMsg', ['Unable to delete the account record']);
                $this->response->redirect('home/account');
                return;
            }

            // Load the account record
            $account = Account::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id
                ]
            ]);

            if (!$account) {
                $this->session->set('errorMsg', ['Unable to delete the account record']);
                $this->response->redirect('home/account');
                return;
            }

            $this->view->account = $account;
        }
    }

    public function templateAction() {

        $templates = Template::find();
        $this->view->templates = $templates;

    }

    public function editTemplateAction() {


        if ($this->request->isPost()) {

            // Get all the vars
            $id = $this->request->getPost('id');
            $templateLabel = $this->request->getPost('templateLabel');

            // Find the template
            $template = Template::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id,
                ]
            ]);

            // Make sure we got the template
            if (!$template) {
                $this->session->set('errorMsg', ['Unable to edit template']);
                $this->response->redirect('home/template');
                return;
            }

            // Save the updated label (if updated)
            if ($template->getLabel() != $templateLabel) {
                $template->setLabel($templateLabel);
            }

            // Save the results
            if ($template->save()) {
                $this->session->set('successMsg',['Successfully updated template label']);
                $this->response->redirect('home/template');
                return;
            } else {
                $this->session->set('errorMsg', ['Unable to update the template']);
                $this->response->redirect('home/template');
                return;
            }

        } else {

            // Get the account id
            $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

            // Confirm we have an id to use
            if (is_null($id)) {
                // Error
                $this->session->set('errorMsg', ['Unable to edit template due to no id being supplied']);
                $this->response->redirect('home/template');
                return;
            }

            // Retrieve the template from the database
            $template = Template::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id
                ]
            ]);

            // If unable to select template, then error out
            if (!$template) {
                $this->session->set('errorMsg', ['Unable to edit template']);
                $this->response->redirect('home/template');
                return;   
            }

            $this->view->template = $template;
            
        }
    }

    public function deleteTemplateAction() {

        // Get the customer id
        $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

        // Confirm we have an id to use
        if (is_null($id)) {
            // Error
            $this->session->set('errorMsg', 'Unable to delete the template record');
            $this->response->redirect('home/template');
        }

        // Load the template record
        $template = Template::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $id
            ]
        ]);

        // Delete the Template
        if ($template->delete()) {
            // Template successfully deleted
            $this->session->set('successMsg',['Successfully deleted template from database']);
            $this->response->redirect('home/template');
        } else {
            // Unable to delete template
            $this->session->set('errorMsg', 'Unable to delete the template record');
            $this->response->redirect('home/template');
        }
    }

    public function manageEnvironmentsAction() {

        // Get the account id
        $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

        // Confirm we have an id to use
        if (is_null($id)) {
            // Error
            $this->session->set('errorMsg', ['Unable to manage environments for account']);
            $this->response->redirect('home/account');
            return;
        }

        // Load the account record
        $account = Account::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $id
            ]
        ]);

        if (!$account) {
            $this->session->set('errorMsg', ['Unable to manage environments for account']);
            $this->response->redirect('home/account');
            return;
        }

        // Get a list of the environments
        $environments = Environment::find();

        // Get a list of plugin packages
        $pluginPackages = PluginPackage::find();

        // Get a list of the wordpress templates
        $wordpressTemplates = Template::find();

        // Get server name
        $serverName = $account->getAccountServerRel()->getServer()->getServerName();

        // Assign view data
        $this->view->acctID = $id;
        $this->view->environments = $environments;
        $this->view->account = $account;
        $this->view->serverName = $serverName;
        $this->view->pluginPackages = $pluginPackages;
        if (count($wordpressTemplates) > 0) {
            $this->view->wordpressTemplates = $wordpressTemplates;
        }

    }

    public function plansAction() {

        $plans = Plan::find();
        $this->view->plans = $plans;

        // Check for successMsg or errorMsg
        if ($this->session->get('successMsg')) {
            $this->view->successMsg = $this->session->get('successMsg');
            $this->session->remove('successMsg');
        }
        if ($this->session->get('errorMsg')) {
            $this->view->errorMsg = $this->session->get('errorMsg');
            $this->session->remove('errorMsg');
        }

    }

    public function addPlanAction() {

        if ($this->request->isPost()) {

            // Get all the vars
            $planName = $this->request->getPost('planName','string');
            $whmPlanName = $this->request->getPost('whmPlanName','string');

            // Check we got input
            if (!$planName || !$whmPlanName) {
                $this->session->set('errorMsg',['Required inputs missing']);
                $this->response->redirect('home/plans');
            } else {

                // Create new plan object
                $plan = new Plan();

                // Set all the plan details
                $plan->setPlanName($planName)
                    ->setWHMPlanName($whmPlanName);

                // Save the new plan
                if (!$plan->save()) {
                    $this->session->set('errorMsg',['Unable to add new plan to the database']);
                    $this->response->redirect('home/plans');
                } else {
                    $this->session->set('successMsg',['Successfully saved new plan to the database']);
                    $this->response->redirect('home/plans');
                }
            }
        }
    }

    /**
     *  Functions for Plugin Packages
     */

    public function pluginPackagesAction() {

        $pluginPackages = PluginPackage::find();
        $this->view->pluginPackages = $pluginPackages;

        if ($this->session->get('successMsg')) {
            $this->view->successMsg = $this->session->get('successMsg');
            $this->session->remove('successMsg');
        }
        if ($this->session->get('errorMsg')) {
            $this->view->errorMsg = $this->session->get('errorMsg');
            $this->session->remove('errorMsg');
        }

    }

    public function addPluginPackageAction() {

        if ($this->request->isPost()) {
            $packageName = $this->request->getPost("packageName");
            $wordpressPlugins = $this->request->getPost("wordpressPlugins");

            $pluginPackage = new PluginPackage();
            $pluginPackage->setDisplayName($packageName);
            
            // Save the new plugin package
            if (!$pluginPackage->save()) {
                $this->session->set('errorMsg',['Unable to add new plugin package to the database']);
                $this->response->redirect('home/pluginPackages');
            } else {
                // We sucessfully created the plugin package entry, now do all the wordpress plugin relationships
                foreach($wordpressPlugins as $wpPlugin) {
                    $pluginPackageWordPressPluginRel = new PluginPackageWordPressPluginRel();
                    $pluginPackageWordPressPluginRel->setWordPressPluginId($wpPlugin)->setPluginPackageId($pluginPackage->getId())->save();
                }
                // Success
                $this->session->set('successMsg',['Successfully saved new plugin package to the database']);
                $this->response->redirect('home/pluginPackages');
            }

        }

        // Grab all the wordpress plugins
        $wordpressPlugins = WordpressPlugin::find();
        $this->view->wordpressPlugins = $wordpressPlugins;

    }

    public function editPluginPackageAction() {

        if ($this->request->isPost()) {

            // Get all the vars
            $id = $this->request->getPost("id");
            $packageName = $this->request->getPost("packageName");
            $wordpressPlugins = $this->request->getPost("wordpressPlugins");

            // Check we got input
            if (!$id || !$packageName || !$wordpressPlugins) {
                $this->session->set('errorMsg',['Required inputs missing']);
                $this->response->redirect('home/pluginPackages');
            
            } else {

                // Get the package from the database
                $pluginPackage = PluginPackage::findFirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $id
                    ]
                ]);

                // Did we find the plugin package
                if (!$pluginPackage) {
                    // No plugin package found by this id
                    $this->session->set('errorMsg',['No Plugin Package found with this ID']);
                    $this->response->redirect('home/pluginPackages');
                
                } else {

                    // Update the plugin details as posted
                    $pluginPackage->setDisplayName($packageName);

                    // Save the plugin package
                    if (!$pluginPackage->save()) {
                        foreach($pluginPackage->getMessages() as $message) {
                            $tmpMessages[] = $message;
                        }
                        $this->session->set('errorMsg',$tmpMessages);
                        $this->response->redirect('home/pluginPackages');
                    } else {

                        // See if any plugins have been unselected
                        $wordpressPluginsRel = $pluginPackage->getPluginPackageWordPressPluginRel();
                        foreach ($wordpressPluginsRel as $wpPlugin) {
                            $wpPluginID = $wpPlugin->getWordPressPlugin()->getId();
                            if (!in_array($wpPluginID,$wordpressPlugins)) {
                                // Doesn't exist in the select box, turf this entry
                                $wpPlugin->delete();
                            }
                        }

                        // Add any new plugins to the database
                        foreach($wordpressPlugins as $wpPlugin) {

                            $pluginPackageWordPressPluginRel = PluginPackageWordPressPluginRel::findFirst([
                                "plugin_package_id = :plugin_package_id: AND wordpress_plugin_id = :wordpress_plugin_id:",
                                "bind" => [
                                    "plugin_package_id" => $pluginPackage->getId(),
                                    "wordpress_plugin_id" => $wpPlugin
                                ]
                            ]);

                            if (!$pluginPackageWordPressPluginRel) {
                                // Does not exist in the database, add it
                                $pluginPackageWordPressPluginRel = new PluginPackageWordPressPluginRel();
                                $pluginPackageWordPressPluginRel->setWordPressPluginId($wpPlugin)->setPluginPackageId($pluginPackage->getId())->save();
                            } else {
                                // Plugin Package does exist, nothing to do
                            }
                        }

                        $this->session->set('successMsg',['Successfully saved plugin package details']);
                        $this->response->redirect('home/pluginPackages');
                    }
                }
            }

        } else {

            // Get the plugin package id
            $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

            // Get the plugin package from the database
            $pluginPackage = PluginPackage::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id
                ]
            ]);

            // Confirm we got a plugin package from the database
            if (!$pluginPackage) {
                // No plugin found by this id
                $this->session->set('errorMsg',['No Plugin Package found with this ID']);
                $this->response->redirect('home/pluginPackages');
            } else {
                // Map the plugin package to the view bag
                $this->view->pluginPackage = $pluginPackage;    
                // Grab all the wordpress plugins
                $wordpressPlugins = WordPressPlugin::find();
                $this->view->wordpressPlugins = $wordpressPlugins;
                // Get a list of all currently assigned wordpress plugins to package
                $getPluginPackageWordPressPluginRel = $pluginPackage->getPluginPackageWordPressPluginRel();
                foreach ($getPluginPackageWordPressPluginRel as $pluginRel) {
                    $pluginArr[] = $pluginRel->getWordPressPlugin()->getId();
                }
                $this->view->pluginsAssigned = $pluginArr;
            }
        }
    }

    /**
     *  Functions for Wordpress Plugins
     */

    public function wordpressPluginsAction() {

        $wordpressPlugins = WordPressPlugin::find();
        $this->view->wordpressPlugins = $wordpressPlugins;

        if ($this->session->get('successMsg')) {
            $this->view->successMsg = $this->session->get('successMsg');
            $this->session->remove('successMsg');
        }
        if ($this->session->get('errorMsg')) {
            $this->view->errorMsg = $this->session->get('errorMsg');
            $this->session->remove('errorMsg');
        }
    }

    public function addWordpressPluginAction() {

        if ($this->request->isPost()) {

            $displayName = $this->request->getPost("displayName");
            $wpSlug = $this->request->getPost("wpSlug");

            // Create a new Wordpress Plugin object
            $plugin = new WordpressPlugin();
            $plugin->setDisplayName($displayName)
                ->setWPSlug($wpSlug);

            // Save the new plugin
            if (!$plugin->save()) {
                $this->session->set('errorMsg',['Unable to add new wordpress plugin to the database']);
                $this->response->redirect('home/wordpressPlugins');
            } else {
                $this->session->set('successMsg',['Successfully saved new wordpress plugin to the database']);
                $this->response->redirect('home/wordpressPlugins');
            }
        }
    }

    public function editWordpressPluginAction() {

        if ($this->request->isPost()) {

            // Get all the vars
            $id = $this->request->getPost("id");
            $displayName = $this->request->getPost("displayName");
            $wpSlug = $this->request->getPost("wpSlug");

            // Check we got input
            if (!$id || !$displayName || !$wpSlug) {
                $this->session->set('errorMsg',['Required inputs missing']);
                $this->response->redirect('home/wordpressPlugins');
            } else {

                // Get the server from the database
                $plugin = WordPressPlugin::findFirst([
                    "id = :id:",
                    "bind" => [
                        "id" => $id
                    ]
                ]);

                // Did we find the plugin
                if (!$plugin) {
                    // No server found by this id
                    $this->session->set('errorMsg',['No Wordpress Plugin found with this ID']);
                    $this->response->redirect('home/wordpressPlugins');
                } else {

                    // Update the plugin details as posted
                    $plugin->setDisplayName($displayName)
                        ->setWPSlug($wpSlug);

                    // Save the plugin
                    if (!$plugin->save()) {
                        $this->session->set('errorMsg',['Unable to edit wordpress plugin details']);
                        $this->response->redirect('home/wordpressPlugins');
                    } else {
                        $this->session->set('successMsg',['Successfully saved wordpress plugin details']);
                        $this->response->redirect('home/wordpressPlugins');
                    }
                }
            }

        } else {

            // Get the customer id
            $id = (isset($_GET['id'])) ? (int) $_GET['id'] : null;

            // Get the server from the database
            $plugin = WordPressPlugin::findFirst([
                "id = :id:",
                "bind" => [
                    "id" => $id
                ]
            ]);

            // Confirm we got a plugin from the database
            if (!$plugin) {
                // No plugin found by this id
                $this->session->set('errorMsg',['No Wordpress Plugin found with this ID']);
                $this->response->redirect('home/wordpressPlugins');
            } else {
                // Map the plugin to the view bag
                $this->view->plugin = $plugin;    
            }
        }
    }

    public function deleteWordpressPluginAction() {

        $id = (int) $_GET['id'];

        // Get the wordpress plugin from the database
        $plugin = WordPressPlugin::findFirst([
            "id = :id:",
            "bind" => [
                "id" => $id
            ]
        ]);

        // Delete the wordpress plugin
        if ($plugin->delete()) {
            $this->session->set('successMsg',['Successfully deleted wordpress plugin from the database']);
            $this->response->redirect('home/wordpressPlugins');
        } else {
            $this->session->set('errorMsg',['Unable to delete wordpress plugin from the database']);
            $this->response->redirect('home/wordpressPlugins');
        }
    }
    
    /**
     *  End of Functions for Wordpress Plugins
     */

    /**
     *	Functions for user management
     */

    public function usersAction() {
    	
    	$users = Users::find();
        $this->view->users = $users;

    	if ($this->session->get('successMsg')) {
    		$this->view->successMsg = $this->session->get('successMsg');
    		$this->session->remove('successMsg');
    	}
    	if ($this->session->get('errorMsg')) {
    		$this->view->errorMsg = $this->session->get('errorMsg');
    		$this->session->remove('errorMsg');
    	}
    	
    }

    public function addUserAction() {

    	if ($this->request->isPost()) {
    		
    		// Get all the field values
    		$username = $this->request->getPost('username');
    		$password = $this->request->getPost('password');
    		$name = $this->request->getPost('name');
    		$email = $this->request->getPost('email');
    		$active = $this->request->getPost('active');

    		// Create a new user
    		$user = new Users();

    		// Save the values
    		$user->setUsername($username)
    			->setPassword($password)
    			->setName($name)
    			->setEmail($email)
    			->setActive($active);

    		if ($user->save()) {
    			// User saved successfully
				$this->view->successMsg = 'User saved successfully';
			} else {
				$this->view->errorMsg = $user->getMessages();
    		}
    	}
    }

    public function editUserAction() {

    	if ($this->request->isPost()) {

    		// Get the field values
    		$id = $this->request->getPost('id');
    		$username = $this->request->getPost('username');
    		$password = $this->request->getPost('password');
    		$name = $this->request->getPost('name');
    		$email = $this->request->getPost('email');
    		$active = $this->request->getPost('active');

    		// Get the user from the database
	    	$user = Users::findFirst([
	    		"id = :id:",
	    		"bind" => [
	    			"id" => $id
	    		]
	    	]);

	    	// Update the user values
	    	$user->setUsername($username)
    			->setPassword($password)
    			->setName($name)
    			->setEmail($email)
    			->setActive($active);

	    	// Save it
	    	if ($user->save()) {
	    		// User saved successfully
	    		$this->session->set('successMsg', 'User saved successfully');
	    		$this->response->redirect('home/users');
			} else {
				$this->session->set('errorMsg', $user->getMessages());
				$this->response->redirect('home/users');
	    	}

    	} else {

    		// Get the location id
    		$id = (int) $_GET['id'];

	    	// Get the user from the database
	    	$user = Users::findFirst([
	    		"id = :id:",
	    		"bind" => [
	    			"id" => $id
	    		]
	    	]);

            // Make sure the user could be located
            if (!$user) {
                $this->session->set('errorMsg', 'Unable to locate user in database');
                $this->response->redirect('home/users');
                return;  
            }

	    	// Store the user data for the page renderer
	    	$this->view->user = $user;

    	}
    }

    public function deleteUserAction() {

    	$id = (int) $_GET['id'];

    	// Get the user from the database
    	$user = Users::findFirst([
    		"id = :id:",
    		"bind" => [
    			"id" => $id
    		]
    	]);

    	// Delete the user
    	if ($user->delete()) {
    		// User saved successfully
    		$this->session->set('successMsg', 'User deleted successfully');
    		$this->response->redirect('home/users');
		} else {
			$this->session->set('errorMsg', $user->getMessages());
			$this->response->redirect('home/users');
    	}
    }

    /**
     *  End of Functions for user management
     */

    private function findLeastLoadedServer() {

        // Define required vars, arrays, etc
        $tmpArray = [];

        // Get the servers from the database
        $servers = Server::find();

        if ($servers) {
            // Loop through each server
            foreach($servers as $server) {
                // Get a list of all accounts assigned to this server and count them
                $count = $server->getAccountServerRel()->count();
                // Create a temporary array with the server id as key and the count as value
                $tmpArray[$server->getId()] = $count;
            }    
        }

        // Sort the array
        asort($tmpArray);

        // Retrieve the first server id and return to calling function
        foreach($tmpArray as $serverID => $count) {
            return $serverID;
        }
        
        // If we get here, return false
        return false;

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
