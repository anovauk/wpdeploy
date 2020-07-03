<table id="serversTable" class="display" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Server Name</th>
			<th>Host Name</th>
			<th>WHM Port</th>
			<th>WHM Username</th>
			<th>WPDeployment Daemon IP</th>
			<th>WPDeployment Daemon Port</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{% for server in servers %}
			<tr>
				<td>{{ server.getID() }}</td>
				<td>{{ server.getServerName() }}</td>
				<td>{{ server.getHostName() }}</td>
				<td>{{ server.getWHMPort() }}</td>
				<td>{{ server.getWHMUsername() }}</td>
				<td>{{ server.getWPDeploymentDaemonIP() }}</td>
				<td>{{ server.getWPDeploymentDaemonPort() }}</td>

				<td>
					<a href="{{ baseUrl }}home/editServer?id={{ server.getId() }}" data-toggle="tooltip" title="Edit Server"><i class="fas fa-edit"></i><a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/deleteServer?id={{ server.getId() }}" data-toggle="tooltip" title="Delete Server"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
		{% endfor %}
	</tbody>
</table>

<script>
	$(document).ready( function () {
    	$('#serversTable').DataTable();
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