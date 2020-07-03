<?php
use Phalcon\Cli\Task;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Adapter\Database as AclList;

class AdminTask extends Task {

    public function mainAction() {
        echo 'Nothing to see here, move on folks' . PHP_EOL;
    }

    public function generateACLAction(array $params) {

    	// Get the Dependency Injector
		$di = Phalcon\DI::getDefault();

		// Create the access list
		$acl = new AclList(
		    [
		        'db' 				=> $di->get('db'),
		        'roles'             => 'Roles',
		        'rolesInherits'     => 'Roles_inherits',
		        'resources'         => 'Resources',
		        'resourcesAccesses' => 'Resources_accesses',
		        'accessList'        => 'Access_list',
		    ]
		);

		// Set default action
		$acl->setDefaultAction(Acl::DENY);

		// Register roles
		$roles = [
			'users'  => new Role(
				'Users',
				'Member privileges, granted after sign in.'
			),
			'guests' => new Role(
				'Guests',
				'Anyone browsing the site who is not signed in is considered to be a "Guest".'
			)
		];
		foreach ($roles as $role) {
			$acl->addRole($role);
		}

		// Private area resources
		$privateResources = [
			'home'			=> [ 	
				'index',
				'account','addAccount','editAccount','deleteAccount','importAccount',
				'manageEnvironments',
				'template','editTemplate','deleteTemplate',
				'wordpressPlugins','addWordpressPlugin','editWordpressPlugin','deleteWordpressPlugin',
				'pluginPackages','addPluginPackage','editPluginPackage','deletePluginPackage',
				'server','addServer','editServer','deleteServer',
				'plans','addPlan','editPlan','deletePlan',
				'users','addUser','deleteUser','editUser'
			],
			'api' => [
				'getEnvironment','deployWordpress','syncWordpress','deleteHTAccessUser','enableHTAccess',
				'disableHTAccess','addHTAccessUser','markAsTemplate','importTemplate'
			]
		];

		foreach ($privateResources as $resource => $actions) {
			$acl->addResource(new Resource($resource), $actions);
		}

		// Public area resources
		$publicResources = [
			'errors'     => [ 'show401', 'show404', 'show500' ],
			'session'    => [ 'index', 'start', 'end' ],
			'index'		 => [ 'index' ],

		];
		foreach ($publicResources as $resource => $actions) {
			$acl->addResource(new Resource($resource), $actions);
		}
		//Grant access to public areas to both users and guests
		foreach ($roles as $role) {
			foreach ($publicResources as $resource => $actions) {
				foreach ($actions as $action){
					$acl->allow($role->getName(), $resource, $action);
				}
			}
		}
		//Grant access to private area to role Users
		foreach ($privateResources as $resource => $actions) {
			foreach ($actions as $action){
				$acl->allow('Users', $resource, $action);
			}
		}
    }

    // This task will generate a password hash for storing in the db manually
    public function generatePasswordHashAction(array $params) {
    	
    	// Password is the first param passed
    	$password = $params[0];

    	// Get the Dependency Injector
		$di = Phalcon\DI::getDefault();
		
		// Grab the crypt service
		$crypt = $di['crypt'];

		// Print out the encrypted password
		print $crypt->encryptBase64($password)."\r\n";
    }

}