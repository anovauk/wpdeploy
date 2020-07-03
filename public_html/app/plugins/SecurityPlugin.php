<?php
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Database as AclList;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin {
	/**
	 * Returns an existing or new access control list
	 *
	 * @returns AclList
	 */
	public function getAcl() {

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
			
		// Return ACL object
		return $acl;
	}

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param Dispatcher $dispatcher
	 * @return bool
	 */
	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {
		
		$auth = $this->session->get('auth');
		
		if (!$auth){
			$role = 'Guests';
		} else {
			$role = 'Users';
		}

		$controller = $dispatcher->getControllerName();
		$action = $dispatcher->getActionName();
		$acl = $this->getAcl();
		
		if (!$acl->isResource($controller)) {
			$dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show404'
			]);
			return false;
		}

		$allowed = $acl->isAllowed($role, $controller, $action);
		if (!$allowed) {
			$dispatcher->forward([
				'controller' => 'errors',
				'action'     => 'show401'
			]);
			return false;
		}
	}
}