<form method="post" action="{{ baseUrl }}home/addServer" autocomplete="off">
	<div class="form-group">
    	<label for="serverName">Server Name</label>
    	<input type="text" class="form-control" name="serverName" id="serverName" aria-describedby="serverNameHelp" placeholder="Enter the server name">
  </div>

	<div class="form-group">
    	<label for="hostName">Host Name</label>
    	<input type="text" class="form-control" name="hostName" id="hostName" aria-describedby="hostNameHelp" placeholder="Enter server host name">
  </div>

  <div class="form-group">
      <label for="whmPort">WHM Port</label>
      <input type="text" class="form-control" name="whmPort" id="whmPort" aria-describedby="whmPortHelp" placeholder="Enter WHM Port Number">
  </div>

  <div class="form-group">
      <label for="whmUsername">WHM Username</label>
      <input type="text" class="form-control" name="whmUsername" id="whmUsername" aria-describedby="whmUsernameHelp" placeholder="Enter WHM Username">
  </div>

  <div class="form-group">
      <label for="whmAPIToken">WHM API Token</label>
      <input type="text" class="form-control" name="whmAPIToken" id="whmAPIToken" aria-describedby="whmAPITokenHelp" placeholder="Enter WHM API Token">
  </div>

  <div class="form-group">
      <label for="wpDeploymentDaemonIP">WP Deployment Daemon IP</label>
      <input type="text" class="form-control" name="wpDeploymentDaemonIP" id="wpDeploymentDaemonIP" aria-describedby="wpDeploymentDaemonIPHelp" placeholder="Enter WP Deployment Daemon IP Address">
  </div>

  <div class="form-group">
      <label for="wpDeploymentDaemonPort">WP Deployment Daemon Port</label>
      <input type="text" class="form-control" name="wpDeploymentDaemonPort" id="wpDeploymentDaemonPort" aria-describedby="wpDeploymentDaemonPortHelp" placeholder="Enter WP Deployment Daemon Port Number">
  </div>

  <button type="submit" class="btn btn-primary">Save Server</button>
</form>

<script>

</script>