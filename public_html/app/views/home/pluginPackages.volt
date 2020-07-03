<table id="packagePluginsTable" class="display" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Package Name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{% for package in pluginPackages %}
			<tr>
				<td>{{ package.getId() }}</td>
				<td>{{ package.getDisplayName() }}</td>

				<td>
					<a href="{{ baseUrl }}home/editPluginPackage?id={{ package.getId() }}" data-toggle="tooltip" title="Edit Plugin Package"><i class="fas fa-edit"></i><a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/deletePluginPackage?id={{ package.getId() }}" data-toggle="tooltip" title="Delete Plugin Package"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
		{% endfor %}
	</tbody>
</table>

<script>
	$(document).ready( function () {
    	$('#packagePluginsTable').DataTable();
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