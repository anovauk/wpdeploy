<form method="post" action="{{ baseUrl }}home/importAccount" autocomplete="off">
	
  <div class="form-group">
    <label for="planID">Plan Name</label>
    <select class="form-control" id="planID" name="planID">
    {% for plan in plans %}
      {% if planID is defined %}
        {% if plan.getID() == planID %}
          <option value="{{ plan.getID() }}" selected>{{ plan.getPlanName() }}</option>
        {% else %}
         <option value="{{ plan.getID() }}">{{ plan.getPlanName() }}</option>
        {% endif %}
      {% else %}
        <option value="{{ plan.getID() }}">{{ plan.getPlanName() }}</option>
      {% endif %}
    {% endfor %}
    </select>
  </div>

  <div class="form-group">
    <label for="serverID">Server Name</label>
    <select class="form-control" id="serverID" name="serverID">
    {% for server in servers %}
      {% if serverID is defined %}
        {% if server.getID() == serverID %}
          <option value="{{ server.getID() }}" selected>{{ server.getServerName() }}</option>
        {% else %}
         <option value="{{ server.getID() }}">{{ server.getServerName() }}</option>
        {% endif %}
      {% else %}
        <option value="{{ server.getID() }}">{{ server.getServerName() }}</option>
      {% endif %}
    {% endfor %}
    </select>
  </div>

  <div class="form-group">
    	<label for="hostUsername">cPanel Username</label>
    	<input type="text" class="form-control" name="hostUsername" id="hostUsername" aria-describedby="hostUsernameHelp" placeholder="Enter the cPanel Username" value="{{ hostUsername }}" required>
  </div>

	<div class="form-group">
    	<label for="hostPassword">cPanel Password</label>
    	<input type="password" class="form-control" name="hostPassword" id="hostPassword" aria-describedby="hostPasswordHelp" placeholder="Enter the cPanel Password" value="{{ hostPassword }}">
  </div>

  <div class="form-check">
    <input type="checkbox" class="form-check-input" name="passwordChange" id="passwordChange" value="1" aria-describedby="passwordChangeHelp">
    <label class="form-check-label" for="passwordChange">Force Change Password</label>
    <small id="passwordChangeHelp" class="form-text text-muted">Force Update The Account Password On Server</small>
  </div>

  <div class="form-check">
    <input type="checkbox" class="form-check-input" name="generateRandomPass" id="generateRandomPass" value="1" aria-describedby="generateRandomPassHelp">
    <label class="form-check-label" for="generateRandomPass">Automatically Generate Random Password</label>
    <small id="generateRandomPassHelp" class="form-text text-muted">Generate a random 16 character password</small>
  </div>

  <button type="submit" class="btn btn-primary">Import Account</button>
  
</form>

<script>

  $(document).ready( function () {
      $('#accountsTable').DataTable();
      $('[data-toggle="tooltip"]').tooltip();
  } );

  {% if successMsg is defined %}
    {% for success in successMsg %}
      toastr.success('{{ success }}');
    {% endfor %}
  {% endif %}
    
  {% if errorMsg is defined %}
    {% for error in errorMsg %}
      toastr.error('{{ error }}');
    {% endfor %}
  {% endif %}

</script>