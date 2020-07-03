<form method="post" action="{{ baseUrl }}home/editTemplate" autocomplete="off">
	
  <input type="hidden" name="id" value="{{ template.getId() }}">

  <div class="form-group">
    	<label for="templateLabel">Template Label</label>
    	<input type="text" class="form-control" name="templateLabel" id="templateLabel" aria-describedby="templateLabelHelp" placeholder="Enter the Template Label Here" value="{{ template.getLabel() }}">
  </div>

  <button type="submit" class="btn btn-primary">Edit Template</button>
  
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