
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  <a class="navbar-brand" href="home">WPDeployment</a>
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  	
  	<span class="navbar-toggler-icon"></span>
  
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    
  	<ul class="navbar-nav mr-auto">
    	
      <li class="nav-item active">
        	<a class="nav-link" href="{{ baseUrl }}home">Home <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
          Accounts
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ baseUrl }}home/account">View Accounts</a>
          <a class="dropdown-item" href="{{ baseUrl }}home/addAccount">Add Account</a>
          <a class="dropdown-item" href="{{ baseUrl }}home/importAccount">Import Account</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
          Setup
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ baseUrl }}home/plans">View Plans</a>
          <a class="dropdown-item" href="{{ baseUrl }}home/addPlan">Add Plan</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ baseUrl }}home/server">View Servers</a>
          <a class="dropdown-item" href="{{ baseUrl }}home/addServer">Add Server</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ baseUrl }}home/template">Manage Templates</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ baseUrl }}home/wordpressPlugins">View Wordpress Plugins</a>
          <a class="dropdown-item" href="{{ baseUrl }}home/addWordpressPlugin">Add Wordpress Plugin</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ baseUrl }}home/pluginPackages">View Plugin Packages</a>
          <a class="dropdown-item" href="{{ baseUrl }}home/addPluginPackage">Add Plugin Package</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
          Tools
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ baseUrl }}home/users">View Users</a>
          <a class="dropdown-item" href="{{ baseUrl }}home/addUser">Add User</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ baseUrl }}session/end">Logout</a>
      </li>

    </ul>
   </div>
 </nav>

 {{ content() }}