<form method="post" action="{{ baseUrl }}home/editAccount" autocomplete="off">
	
  <input type="hidden" name="id" value="{{ account.getId() }}">

  <div class="form-group">
    <label for="planID">Plan Name</label>
    <select class="form-control" id="planID" name="planID">
    {% for plan in plans %}
      {% if account.getAccountServerRel().getID() == plan.getID() %}
        <option value="{{ plan.getID() }}" selected>{{ plan.getPlanName() }}</option>
      {% else %}
        <option value="{{ plan.getID() }}">{{ plan.getPlanName() }}</option>
      {% endif %}
    {% endfor %}
    </select>
  </div>

  <div class="form-group">
    	<label for="hostUsername">cPanel Username</label>
    	<input type="text" class="form-control" name="hostUsername" id="hostUsername" aria-describedby="hostUsernameHelp" placeholder="Enter the cPanel Username" value="{{ account.getHostUsername() }}">
  </div>

	<div class="form-group">
    	<label for="hostPassword">cPanel Password</label>
    	<input type="text" class="form-control" name="hostPassword" id="hostPassword" aria-describedby="hostPasswordHelp" placeholder="Enter the cPanel Password" value="{{ account.getHostPassword() }}">
  </div>

  <div class="form-group">
      <label for="hostDomain">cPanel Domain Name</label>
      <input type="text" class="form-control" name="hostDomain" id="hostDomain" aria-describedby="hostDomainHelp" placeholder="Enter the cPanel Domain Name" value="{{ account.getHostDomain() }}">
  </div>

  <button type="submit" class="btn btn-primary">Edit Account</button>
  
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