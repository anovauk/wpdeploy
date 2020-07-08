<form method="post" action="{{ baseUrl }}home/editPluginPackage" autocomplete="off">
	
  <input type="hidden" name="id" value="{{ pluginPackage.getId() }}">

  <div class="form-group">
    	<label for="packageName">Package Name</label>
    	<input type="text" class="form-control" name="packageName" id="packageName" aria-describedby="packageNameHelp" placeholder="Enter the Package Name" value="{{ pluginPackage.getDisplayName() }}">
  </div>

	<div class="form-group">
    	<label for="wordpressPlugins">Wordpress Plugins</label>
      <select class="form-control" name="wordpressPlugins[]" id="wordpressPlugins" size="10" multiple>
      {% for wordpressPlugin in wordpressPlugins %}
        {% if wordpressPlugin.getId() in pluginsAssigned %}
          <option value="{{ wordpressPlugin.getId() }}" selected>{{ wordpressPlugin.getDisplayName() }}</option>
        {% else %}
          <option value="{{ wordpressPlugin.getId() }}">{{ wordpressPlugin.getDisplayName() }}</option>
        {% endif %}
      {% endfor %}
      </select>
  </div>

  <button tywpe="submit" class="btn btn-primary">Update Plugin Package</button>
  
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