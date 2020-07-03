<form method="post" action="{{ baseUrl }}home/editWordpressPlugin" autocomplete="off">
  <input type="hidden" name="id" value="{{ plugin.getId() }}">
	<div class="form-group">
    	<label for="displayName">Display Name</label>
    	<input type="text" class="form-control" name="displayName" id="displayName" aria-describedby="displayNameHelp" placeholder="Enter the Display Name" value="{{ plugin.getDisplayName() }}">
  </div>

	<div class="form-group">
    	<label for="wpSlug">Wordpress Slug</label>
    	<input type="text" class="form-control" name="wpSlug" id="wpSlug" aria-describedby="wpSlugHelp" placeholder="Enter Wordpress Slug Name" value="{{ plugin.getWPSlug() }}">
  </div>

  <button type="submit" class="btn btn-primary">Update Wordpress Plugin</button>
</form>