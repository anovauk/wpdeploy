<form method="post" action="{{ baseUrl }}home/addWordpressPlugin" autocomplete="off">
	
  <div class="form-group">
    	<label for="displayName">Display Name</label>
    	<input type="text" class="form-control" name="displayName" id="displayName" aria-describedby="displayNameHelp" placeholder="Enter the Display Name" value="">
  </div>

	<div class="form-group">
    	<label for="wpSlug">Wordpress Slug</label>
    	<input type="text" class="form-control" name="wpSlug" id="wpSlug" aria-describedby="wpSlugHelp" placeholder="Enter the WP Slug Name" value="">
  </div>

  <div class="form-group">
      	<label for="wpSlug">Git Repository</label>
      	<input type="text" class="form-control" name="wpSlug" id="wpSlug" aria-describedby="gitRepository" placeholder="Enter path to git repository" value="">
    </div>

  <button type="submit" class="btn btn-primary">Add Plugin</button>
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