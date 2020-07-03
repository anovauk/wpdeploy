<table id="customersTable" class="display" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Username</th>
			<th>Name</th>
			<th>EMail</th>
			<th>Created At</th>
			<th>Active</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{% for item in users %}
			<tr>
				<th scope="row">{{item.getId() }}</th>
				<td>{{ item.getUsername() }}</td>
				<td>{{ item.getName() }}</td>
				<td>{{ item.getEmail() }}</td>
				<td>{{ item.getCreatedAt() }}</td>
				<td>{{ item.getActive() }}</td>
				<td>
					<a href="{{ baseUrl }}home/editUser?id={{ item.getId() }}" data-toggle="tooltip" title="Edit User"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/deleteUser?id={{ item.getId() }}" data-toggle="tooltip" title="Delete User" onClick="return confirm('Are you sure you want to delete this user?')"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
		{% endfor %}
	</tbody>
</table>

<script>

	$(document).ready( function () {
    	$('#customersTable').DataTable();
    	$('[data-toggle="tooltip"]').tooltip();
	} );

	{% if successMsg is defined %}
		toastr.success('{{ successMsg }}');
	{% endif %}
	  
	{% if errorMsg is defined %}
		toastr.error('{{ errorMsg }}');
	{% endif %}

</script>