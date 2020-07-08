<table id="wordpressPluginsTable" class="display" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Wordpress Plugin Name</th>
			<th>WP Slug</th>
			<th>Git Repository</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{% for plugin in wordpressPlugins %}
			<tr>
				<td>{{ plugin.getId() }}</td>
				<td>{{ plugin.getDisplayName() }}</td>
				<td>{{ plugin.getWPSlug() }}</td>
				<td>{{ plugin.getGitRepository() }}</td>

				<td>
					<a href="{{ baseUrl }}home/editWordpressPlugin?id={{ plugin.getId() }}" data-toggle="tooltip" title="Edit Wordpress Plugin"><i class="fas fa-edit"></i><a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/deleteWordpressPlugin?id={{ plugin.getId() }}" data-toggle="tooltip" title="Delete Wordpress Plugin"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
		{% endfor %}
	</tbody>
</table>

<script>
	$(document).ready( function () {
    	$('#wordpressPluginsTable').DataTable();
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