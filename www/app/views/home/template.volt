<table id="templatesTable" class="display" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Template Label</th>
			<th>Template Domain</th>
			<th>Template Environment</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{% for template in templates %}
			<tr>
				<td>{{ template.getId() }}</td>
				<td>{{ template.getLabel() }}</td>
				<td>{{ template.getAccount().getHostDomain() }}</td>
				<td>{{ template.getEnvironment().getName() }}</td>

				<td>
					<a href="{{ baseUrl }}home/editTemplate?id={{ template.getId() }}" data-toggle="tooltip" title="Edit Template"><i class="fas fa-edit"></i><a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/deleteTemplate?id={{ template.getId() }}" data-toggle="tooltip" title="Delete Template"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
		{% endfor %}
	</tbody>
</table>

<script>
	$(document).ready( function () {
    	$('#templatesTable').DataTable();
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