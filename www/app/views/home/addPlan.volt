<form method="post" action="{{ baseUrl }}home/addPlan" autocomplete="off">
	
  <div class="form-group">
    	<label for="planName">Plan Name</label>
    	<input type="text" class="form-control" name="planName" id="planName" aria-describedby="planNameHelp" placeholder="Enter the Plan Name" value="">
  </div>

	<div class="form-group">
    	<label for="whmPlanName">WHM Plan Name</label>
    	<input type="text" class="form-control" name="whmPlanName" id="whmPlanName" aria-describedby="whmPlanNameHelp" placeholder="Enter the WHM Plan Name" value="">
  </div>

  <button type="submit" class="btn btn-primary">Add Account</button>
</form>

<script>
  $(document).ready( function () {
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