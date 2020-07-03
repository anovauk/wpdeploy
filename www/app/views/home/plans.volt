<table id="plansTable" class="display" style="width:100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Plan Name</th>
			<th>WHM Plan Name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{% for plan in plans %}
			<tr>
				<td>{{ plan.getID() }}</td>
				<td>{{ plan.getPlanName() }}</td>
				<td>{{ plan.getWHMPlanName() }}</td>

				<td>
					<a href="{{ baseUrl }}home/editPlan?id={{ plan.getID() }}" data-toggle="tooltip" title="Edit Plan"><i class="fas fa-edit"></i><a>&nbsp;&nbsp;
					<a href="{{ baseUrl }}home/deletePlan?id={{ plan.getID() }}" data-toggle="tooltip" title="Delete Plan"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
		{% endfor %}
	</tbody>
</table>

<script>
	$(document).ready( function () {
    	$('#plansTable').DataTable();
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