<table id="accountsTable" class="display" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Host Username</th>
			<th>Host Domain</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{% for account in accounts %}
			<tr>
				<td>{{ account.getID() }}</td>
				<td>{{ account.getHostUsername() }}</td>
				<td>{{ account.getHostDomain() }}</td>

				<td>
					<a href="{{ baseUrl }}home/manageEnvironments?id={{ account.getId() }}" data-toggle="tooltip" title="Manage Environments"><i class="fas fa-cloud"></i></a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/editAccount?id={{ account.getId() }}" data-toggle="tooltip" title="Edit Account"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/deleteAccount?id={{ account.getId() }}" data-toggle="tooltip" title="Delete Account"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
		{% endfor %}
	</tbody>
</table>

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