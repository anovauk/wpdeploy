	
	<!-- Modal for Wordpress Deployment -->
	<div class="modal fade" id="deployWordpressModal" tabindex="-1" role="dialog" aria-labelledby="deployWordpressModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="deployWordpressModalLabel">Deploy Wordpress Installation</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        
	      	<form id="wpDeployForm" autocomplete="off">

	      		<input type="hidden" id="formDeployWordpressAccountID" name="account_id" value="{{ acctID }}">
	      		<input type="hidden" id="formDeployWordpressEnvironmentID" name="environment_id" value="">

			  <div class="form-group">
		    	<label for="pluginPackage">Wordpress Plugin Packages</label>
		      	<select class="form-control" name="pluginPackage" id="pluginPackage">
		      	{% for pluginPackage in pluginPackages %}
		        	<option value="{{ pluginPackage.getId() }}">{{ pluginPackage.getDisplayName() }}</option>
		      	{% endfor %}
		      	</select>
		  	</div>

			  <div class="form-group">
			      <label for="wpSiteTitle">WP Site Title</label>
			      <input type="text" class="form-control" name="wpSiteTitle" id="wpSiteTitle" aria-describedby="wpSiteTitleHelp" placeholder="Enter the Wordpress Site Title">
			  </div>

			  <div class="form-group">
			      <label for="wpAdminUser">WP Admin Username</label>
			      <input type="text" class="form-control" name="wpAdminUser" id="wpAdminUser" aria-describedby="wpAdminUserHelp" placeholder="Enter the Wordpress Admin Username">
			  </div>

			  <div class="form-group">
			      <label for="wpAdminPassword">WP Admin Password</label>
			      <input type="text" class="form-control" name="wpAdminPassword" id="wpAdminPassword" aria-describedby="wpAdminPasswordHelp" placeholder="Enter the Wordpress Admin Password">
			  </div>

			  <div class="form-group">
			      <label for="wpAdminEmail">WP Admin Email</label>
			      <input type="text" class="form-control" name="wpAdminEmail" id="wpAdminEmail" aria-describedby="wpAdminEmailHelp" placeholder="Enter the Wordpress Admin Email">
			  </div>
	      	</form>

	      	<div id="wpDeployLoader" class="text-center">
			    <div class="spinner-border" role="status">
			        <span class="sr-only">Loading...</span>
			    </div>
			</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" id="WPDeployFormClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" id="submitWPDeployForm" class="btn btn-primary">Deploy Wordpress</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Wordpress Deploy Modal -->

	<!-- Wordpress Sync Modal -->
	<div class="modal fade" id="syncWordpressModal" tabindex="-1" role="dialog" aria-labelledby="syncWordpressModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="syncWordpressModalLabel">Sync Wordpress To Environment</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	       
	      	<form id="wpSyncToForm" autocomplete="off">

	      		<input type="hidden" id="formSyncWordpressAccountID" name="account_id" value="{{ acctID }}">
	      		<input type="hidden" id="formSyncWordpressEnvironmentID" name="environment_id" value="">

	      		<div class="form-group">
				    <label for="syncWordpressEnvironment">Select Environment To Sync To</label>
				    <select class="form-control" id="syncWordpressEnvironment" name="syncWordpressToEnvironment">
				    <option value="" disabled selected>None</option>
				    {% for environment in environments %}		      
				    	<option value="{{ environment.getId() }}">{{ environment.getName() }}</option>
				    {% endfor %}
				    </select>
	 			 </div>

	      	</form>

	      	<div id="wpSyncLoader" class="text-center">
			    <div class="spinner-border" role="status">
			        <span class="sr-only">Loading...</span>
			    </div>
			</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" id="WPSyncFormClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" id="submitWPSyncForm" class="btn btn-primary">Sync Wordpress</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Wordpress Sync Modal -->

	<!-- Manage Users Modal -->
	<div class="modal fade" id="manageUsersModal" tabindex="-1" role="dialog" aria-labelledby="manageUsersModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="manageUsersModalLabel">Manage Users</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	      	<form>
	      		<input type="hidden" id="formManageUsersAccountID" name="account_id" value="{{ acctID }}">
	      		<input type="hidden" id="formManageUsersEnvironmentID" name="environment_id" value="">
	      	</form>

			<table id="usersTable" class="display" style="width:100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Username</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

			<hr>

			<h4>Add New User</h4>
	       
	      	<form id="addUsersForm" autocomplete="off">

	      		<input type="hidden" id="formAddUsersAccountID" name="account_id" value="{{ acctID }}">
	      		<input type="hidden" id="formAddUsersEnvironmentID" name="environment_id" value="">

	      		<div class="form-group">
				    <label for="username">Username </label>
				    <input type="text" id="username" name="username">
	 			</div>
	 			<div class="form-group">
				    <label for="password">Password </label>
				    <input type="text" id="password" name="password">
	 			</div>

	      	</form>

	      	<div id="manageUsersLoader" class="text-center">
			    <div class="spinner-border" role="status">
			        <span class="sr-only">Loading...</span>
			    </div>
			</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" id="manageUsersClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" id="submitAddUsersForm" class="btn btn-primary">Add User</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Wordpress Sync Modal -->

	<!-- Wordpress Template Modal -->
	<div class="modal fade" id="templateModal" tabindex="-1" role="dialog" aria-labelledby="templateModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="templateModalLabel">Set Installation as Template</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	       
	      	<form id="templateForm" autocomplete="off">

	      		<input type="hidden" id="formTemplateAccountID" name="account_id" value="{{ acctID }}">
	      		<input type="hidden" id="formTemplateEnvironmentID" name="environment_id" value="">

	      		<div class="form-group">
	      			<label for="templateLabel">Enter template label</label>
	      			<input type="text" name="templateLabel" id="templateLabel">
	      		</div>

	      	</form>

	      	<div id="templateLoader" class="text-center">
			    <div class="spinner-border" role="status">
			        <span class="sr-only">Saving...</span>
			    </div>
			</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" id="templateFormClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" id="submitTemplateForm" class="btn btn-primary">Save Template</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End TemplateModal -->

	<!-- Import Template Modal -->
	<div class="modal fade" id="importTemplateModal" tabindex="-1" role="dialog" aria-labelledby="importTemplateModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="importTemplateModalLabel">Import Template Into Current Environment</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	       
	      	<form id="importTemplateForm" autocomplete="off">

	      		<input type="hidden" id="formImportTemplateAccountID" name="account_id" value="{{ acctID }}">
	      		<input type="hidden" id="formImportTemplateEnvironmentID" name="environment_id" value="">

	      		<div class="form-group">
	      			<label for="importTemplateLabel">Import Template</label>
	      			<select class="form-control" id="templateID" name="templateID">
	      			{% if wordpressTemplates is defined %}
	      				{% for template in wordpressTemplates %}
			    			<option value="{{ template.getID() }}">{{ template.getLabel() }}</option>
				    	{% endfor %}
				    {% endif %}
				    </select>
	      		</div>
	      	</form>

	      	<div id="importTemplateLoader" class="text-center">
			    <div class="spinner-border" role="status">
			        <span class="sr-only">Saving...</span>
			    </div>
			</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" id="importTemplateFormClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" id="submitImportTemplateForm" class="btn btn-primary">Import Template</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End TemplateModal -->

	<!-- Begin standard view -->
	<form>
		<input id="acctID" type="hidden" name="acctID" value="{{ acctID }}">
	</form>

	<div class="row">
		<div class="col-md-6">
			<h4><center>Account Domain: {{ account.getHostDomain() }}</center></h4>
		</div>
		<div class="col-md-6">
			<center><h4>Server Name: {{ serverName }}</center></h4>
		</div>
	</div>

    <div class="row">
        <div class="col-md-4 offset-md-4">
        	 <div class="form-group">
			    <label for="environment">Select Environment</label>
			    <select class="form-control" id="environment" name="environment">
			    <option value="" disabled selected>None</option>
			    {% for environment in environments %}		      
			    	<option value="{{ environment.getId() }}">{{ environment.getName() }}</option>
			    {% endfor %}
			    </select>
 			 </div>
        </div>
    </div>

    <div id="actionsBarLoader" class="text-center">
	    <div class="spinner-border" role="status">
	        <span class="sr-only">Loading...</span>
	    </div>
	</div>

    <div class="row" id="actionsBar">
        <div class="col-md-6 offset-md-3">
        	 <div class="form-group">
        	 	
        	 	<button type="button" id="deployWordpress" class="btn btn-default" aria-label="Deploy WordPress" data-tooltip="tooltip" data-toggle="modal" title="Deploy Wordpress" data-target="#deployWordpressModal">
        	 		<span class="fas fa-fw fa-7x fa-arrow-circle-up" aria-hidden="true"></span>
        	 	</button>

        	 	<button type="button" id="syncWordpress" class="btn btn-default" aria-label="Sync To" data-tooltip="tooltip" data-toggle="modal" title="Sync WordPress Install To" data-target="#syncWordpressModal">
        	 		<span class="fas fa-fw fa-7x fa-sync-alt" aria-hidden="true"></span>
        	 	</button>

        	 	<button type="button" id="importTemplate" class="btn btn-default" aria-label="Import Template" data-tooltip="tooltip" data-toggle="modal" title="Import Template To Current Environment" data-target="#importTemplateModal">
        	 		<span class="fas fa-fw fa-7x fa-upload" aria-hidden="true"></span>
        	 	</button>

        	 	<button type="button" id="enableHTAccess" class="btn btn-default" aria-label="Enable Directory Security" data-tooltip="tooltip" title="Enable Directory Security">
        	 		<span class="fas fa-fw fa-7x fa-lock" aria-hidden="true"></span>
        	 	</button>

        	 	<button type="button" id="disableHTAccess" class="btn btn-default" aria-label="Disable Directory Security" data-tooltip="tooltip" title="Disable Directory Security">
        	 		<span class="fas fa-fw fa-7x fa-lock-open" aria-hidden="true"></span>
        	 	</button>

        	 	<button type="button" id="manageUsers" class="btn btn-default" aria-label="Manage Users" data-tooltip="tooltip" data-toggle="modal" title="Manage Directory Security Users" data-target="#manageUsersModal">
        	 		<span class="fas fa-fw fa-7x fa-users" aria-hidden="true"></span>
        	 	</button>

        	 	<button type="button" id="setTemplate" class="btn btn-default" aria-label="Mark Install as Template" data-tooltip="tooltip" data-toggle="modal" title="Mark Install as Template" data-target="#templateModal">
        	 		<span class="fas fa-fw fa-7x fa-marker" aria-hidden="true"></span>
        	 	</button>

 			 </div>
        </div>
    </div>
    <!-- End Normal View -->

    <script>

	    $(document).ready(function(){

	    	var environmentID;
			
			// Activate bootstrap tooltips
			$('[data-tooltip="tooltip"]').tooltip();

			// Hide the loading image on actionsBarLoader
			$("#actionsBarLoader").hide();
			
			// Hide the actionsBar
			$("#actionsBar").hide();

			// Hide the loading image on wpDeployLoader
			$("#wpDeployLoader").hide();

			// Hide the loading image on wpSyncLoader
			$("#wpSyncLoader").hide();

			// Hide the loading image on manageUsersLoader
			$("#manageUsersLoader").hide();

			// Hide the saving loader image on templateLoader
			$("#templateLoader").hide();

			// Hide the import  loader image on templateLoader
			$("#importTemplateLoader").hide();

			// Submit WP Deploy Form
			$("#submitWPDeployForm").click(function() {
				// Disable buttons
				$("#WPDeployFormClose").prop('disabled', true);
				$("#submitWPDeployForm").prop('disabled', true);
				// Serialize the form
				var str = $("#wpDeployForm").serialize();
				// Show the loader
				$("#wpDeployLoader").show();
				// Send the data to the api
				sendRemoteData('{{ baseUrl }}api/deployWordpress', str, parseResults, doneSubmitWPDeployForm, environmentID );
			});

			// Submit WP Sync Form
			$("#submitWPSyncForm").click(function() {
				// Disable buttons
				$("#WPSyncFormClose").prop('disabled', true);
				$("#submitWPSyncForm").prop('disabled', true);
				// Serialize form
				var str = $("#wpSyncToForm").serialize();
				// Show the loader
				$("#wpSyncLoader").show();
				// Send the data to the api
				sendRemoteData('{{ baseUrl }}api/syncWordpress', str, parseResults, doneSubmitWPSyncForm, environmentID );
			});

			// Submit Add Users Form
			$("#submitAddUsersForm").click(function() {
				// Disable buttons
				$("#manageUsersClose").prop('disabled', true);
				$("#submitAddUsersForm").prop('disabled', true);
				// Serialize the form
				var str = $("#addUsersForm").serialize();
				// Show the loader
				$("#manageUsersLoader").show();
				// Send the data to the api
				sendRemoteData('{{ baseUrl }}api/addHTAccessUser', str, parseResults, doneSubmitAddUsersForm, environmentID );
			});

			// Submit Template Form
			$("#submitTemplateForm").click(function() {
				// Disable buttons
				$("#templateFormClose").prop('disabled', true);
				$("#submitTemplateForm").prop('disabled', true);
				// Serialize the form
				var str = $("#templateForm").serialize();
				// Show the loader
				$("#templateLoader").show();
				// Send the data to the api
				sendRemoteData('{{ baseUrl }}api/markAsTemplate', str, parseResults, doneSubmitTemplateForm, environmentID );
			});


			// Submit Import Template Form
			$("#submitImportTemplateForm").click(function() {
				// Disable buttons
				$("#importTemplateFormClose").prop('disabled', true);
				$("#submitImportTemplateForm").prop('disabled', true);
				// Serialize the form
				var str = $("#importTemplateForm").serialize();
				// Show the loader
				$("#importTemplateLoader").show();
				// Send the data to the api
				sendRemoteData('{{ baseUrl }}api/importTemplate', str, parseResults, doneSubmitImportTemplateForm, environmentID );
			});

			// Callback function for Submit Import Template Form
			function doneSubmitImportTemplateForm(environmentID) {
				// Hide the loader
				$("#importTemplateLoader").hide();
				// Reset the form
				$("#importTemplateForm").trigger("reset");
				// Enable the buttons again
				$("#importTemplateFormClose").prop('disabled', false);
				$("#submitImportTemplateForm").prop('disabled', false);
				// Hide the modal
				$("#importTemplateModal").modal("hide");
				// Refresh the action bar
				refreshActionBar(environmentID);
			}

			// Callback function for Submit Template Form
			function doneSubmitTemplateForm(environmentID) {
				// Hide the loader
				$("#templateLoader").hide();
				// Reset the form
				$("#templateForm").trigger("reset");
				// Enable the buttons again
				$("#templateFormClose").prop('disabled', false);
				$("#submitTemplateForm").prop('disabled', false);
				// Hide the modal
				$("#templateModal").modal("hide");
				// Reload entire page
				location.reload();
			}

			// Callback function for Submit Add Users Form
			function doneSubmitAddUsersForm(environmentID) {
				// Hide loader
				$("#manageUsersLoader").hide();
				// Reset the form
				$("#addUsersForm").trigger("reset");
				// Enable the buttons again
				$("#manageUsersClose").prop('disabled', false);
				$("#submitAddUsersForm").prop('disabled', false);
				// Hide the Modal
				$("#manageUsersModal").modal("hide");
				// Refresh the action bar
				refreshActionBar(environmentID);
			}

			// Callback function for Submit WP Deploy Form
			function doneSubmitWPDeployForm(environmentID) {
				// Hide loader
				$("#wpDeployLoader").hide();
				// Reset the form
				$("#wpDeployForm").trigger("reset");
				// Enable the buttons again
				$("#WPDeployFormClose").prop('disabled', false);
				$("#submitWPDeployForm").prop('disabled', false);
				// Hide the Modal
				$("#deployWordpressModal").modal("hide");
				// Refresh the action bar
				refreshActionBar(environmentID);
			}

			// Callback function for Submit WP Sync Form
			function doneSubmitWPSyncForm(environmentID) {
				// Hide the loader
				$("#wpSyncLoader").hide();
				// Reset the form
				$("#wpSyncToForm").trigger("reset");
				// Enable the buttons again
				$("#WPSyncFormClose").prop('disabled', false);
				$("#submitWPSyncForm").prop('disabled', false);
				// Hide the modal
				$("#syncWordpressModal").modal("hide");
				// Refresh the action bar
				refreshActionBar(environmentID);
			}

			// On selectbox change
			$('#environment').change(function() {
	    		// Get the environment ID
	    		environmentID = $(this).val();
	    		// Refresh the actionbar
	    		refreshActionBar(environmentID);
			});

			function refreshActionBar(environmentID) {
	    		// Hide the actions bar
				$("#actionsBar").hide();
				// Get the accountID
	    		var accountID = $("#acctID").val();
	    		// Update hidden input fields with the environmentID
	    		$("#formDeployWordpressEnvironmentID").val(environmentID);
	    		$("#formSyncWordpressEnvironmentID").val(environmentID);
	    		$("#formAddUsersEnvironmentID").val(environmentID);
	    		$("#formManageUsersEnvironmentID").val(environmentID);
	    		$("#formTemplateEnvironmentID").val(environmentID);
	    		$("#formImportTemplateEnvironmentID").val(environmentID);
	    		// Show the loader
	    		$("#actionsBarLoader").show();
	    		// Get data from the api
	    		getRemoteData('{{ baseUrl }}api/getEnvironment?account_id=' + accountID + '&environment_id=' + environmentID, populateActionBar, doneRefreshActionBar, environmentID);
			}

			function doneRefreshActionBar(environmentID) {
				// Hide the loader
				$("#actionsBarLoader").hide();
			}

			function populateActionBar(results) {

				if (results.resultdata.wordpress == 0) {
					// Show the Wordpress deployment button
					$("#deployWordpress").show();
					// Hide the Sync Wordpress option
					$("#syncWordpress").hide();
					// Hide the mark as template option
					$("#markAsTemplate").hide();
					if (results.resultdata.template == 0) {
						$("#setTemplate").hide();
					}
				} else {
					// Hide the wordpress deployment button
					$("#deployWordpress").hide();
					// Show the Sync Wordpress Option
					$("#syncWordpress").show();
					// Show the mark as template option
					$("#markAsTemplate").show();
					if (results.resultdata.template == 0) {
						$("#setTemplate").show();
					} else {
						$("#setTemplate").hide();
					}
				}

				// Is directory security enabled?
				if (results.resultdata.htaccess == 0) {
					// No it's not, let's make sure a wordpress install exists
					if (results.resultdata.wordpress == 0) {
						// No it doesnt
						// We hide the enable htaccess button and hide the disable and manage users
						// Hide the add htaccess button
						$("#enableHTAccess").hide();
						// Hide the change htaccess button
						$("#disableHTAccess").hide();
						// Hide the Manage Users button
						$("#manageUsers").hide();	
					} else {
						// Yes a wordpress install exists, show the enable htaccess button but hide the disable
						// and manage users buttons
						$("#enableHTAccess").show();
						// Hide the change htaccess button
						$("#disableHTAccess").hide();
						// Hide the Manage Users button
						$("#manageUsers").hide();	
					}
				} else {
					// Directory security is enabled
					// Check to see if we have wordpress install
					if (results.resultdata.wordpress == 0) {
						// No wordpress install
						// Disable all buttons
						// Hide the add htaccess button
						$("#enableHTAccess").hide();
						// Hide the change htaccess button
						$("#disableHTAccess").hide();
						// Hide the Manage Users button
						$("#manageUsers").hide();	
					} else {
						// Yes we have a wordpress install
						// Hide the add htaccess button
						$("#enableHTAccess").hide();
						// Show the change htaccess button
						$("#disableHTAccess").show();
						// Show the manage users button
						$("#manageUsers").show();
					}
				}

				$("#usersTable tbody tr").remove();

				if (typeof results.resultdata.htaccessData !== 'undefined') {

					$.each(results.resultdata.htaccessData, function( index, value) {
						
						// Create string of row data
						var rowData = '<tr id="row' + index + '">';
						rowData += '<td>' + index + '</td>';
						rowData += '<td>' + value + '</td>';
						rowData += '<td>';
						rowData += '<button type="button" id="deleteUser' + index + '" class="btn btn-default deleteUser" aria-label="Delete User" data-tooltip="tooltip" data-username="' + value + '" data-id="' + index + '">';
						rowData += '<span class="fas fa-fw fa-1x fa-trash" aria-hidden="true"></span>';
						rowData += '</button>';

						// Add row to table
						$('#usersTable > tbody:last-child').append(rowData);

						var rowData = '';

					});
				}

				{% if wordpressTemplates is defined %}
					// Show the import template button
					$("#importTemplate").show();
				{% else %}
					// Hide the import template button
					$("#importTemplate").hide();
				{% endif %}

				$('#usersTable').DataTable();
    			$('[data-toggle="tooltip"]').tooltip();

    			// Show the actionsBar
				$("#actionsBar").show();

				// Function used when deleting a specific user from the system
				$(".deleteUser").click(function() {

					// Show the loader
					$("#manageUsersLoader").show();

					// Get username and rowid from the button
					var username = $(this).attr("data-username");
					var rowId = $(this).attr("data-id");

					// Get the accountID
	    			var accountID = $("#acctID").val();

					getRemoteData('{{ baseUrl }}api/deleteHTAccessUser?account_id=' + accountID + '&environment_id=' + environmentID + '&username=' + username, deleteHTAccessUserCallback, doneDeleteHTAccess, rowId );
				});

				// Function used when enabling directory security
				$("#enableHTAccess").click(function() {

					// Hide the actionsBar
					$("#actionsBar").hide();

					// Show the loading image on actionsBarLoader
					$("#actionsBarLoader").show();

					// Get the accountID
	    			var accountID = $("#acctID").val();

	    			getRemoteData('{{ baseUrl }}api/enableHTAccess?account_id=' + accountID + '&environment_id=' + environmentID, enableHTAccessCallback );

				});

				// Function used when disabling directory security
				$("#disableHTAccess").click(function() {

					// Hide the actionsBar
					$("#actionsBar").hide();

					// Show the loading image on actionsBarLoader
					$("#actionsBarLoader").show();

					// Get the accountID
	    			var accountID = $("#acctID").val();

	    			getRemoteData('{{ baseUrl }}api/disableHTAccess?account_id=' + accountID + '&environment_id=' + environmentID, disableHTAccessCallback );

				});
			}

			function enableHTAccessCallback(results) {

				// If successful then display a message
				if (results.status == "success") {
					toastr.success(results.resultdata);
				}

				// If error then display error message
				if (results.error) {
					toastr.error(results.error);
				}

				// Hide the enable htaccess button
				$("#enableHTAccess").hide();
				// Show both the disable htaccess and manage users buttons
				$("#disableHTAccess").show();
				$("#manageUsers").show();

				// Hide the loading image on actionsBarLoader
				$("#actionsBarLoader").hide();

				// Show the actionsBar
				$("#actionsBar").show();

			}

			function disableHTAccessCallback(results) {

				// If successful then display a message
				if (results.status == "success") {
					toastr.success(results.resultdata);
				}

				// If error then display error message
				if (results.error) {
					toastr.error(results.error);
				}

				// Show the enable htaccess button
				$("#enableHTAccess").show();
				// Hide both the disable htaccess and manage users buttons
				$("#disableHTAccess").hide();
				$("#manageUsers").hide();

				// Hide the loading image on actionsBarLoader
				$("#actionsBarLoader").hide();

				// Show the actionsBar
				$("#actionsBar").show();

			}

			function deleteHTAccessUserCallback(results) {
				
				// Hide the loader
				$("#manageUsersLoader").hide();

				// If successful then display a message
				if (results.status == "success") {
					toastr.success(results.resultdata);
				}

				// If error then display error message
				if (results.error) {
					toastr.error(results.error);
				}
			}

			function doneDeleteHTAccess(rowID) {
				$("#row" + rowID).remove();
			}

			function parseResults(results) {

				// If successful then display a message
				if (results.status == "success") {
					toastr.success(results.resultdata);
					refreshActionBar(environmentID);
				}

				// If error then display error message
				if (results.error) {
					toastr.error(results.error);
				}

			}

		    function getRemoteData(url, callback, doneCallBack, param1) {
			 	var jqxhr = $.getJSON(url, function(data, status) {
			 		callback(data);
			 	});

			 	if (doneCallBack) {
			 		if (param1) {
			 			jqxhr.done(function() {
			 				doneCallBack(param1);		
			 			});
			 		} else {
			 			jqxhr.done(function() {
			 				doneCallBack();		
			 			});
			 		}
			 	}
			}

			function sendRemoteData(url, data, callback, doneCallBack, param1) {
				var jqxhr = $.post(url, data, function(data) {
					data = JSON.parse(data);
					callback(data);
				});

				if (doneCallBack) {
			 		if (param1) {
			 			jqxhr.done(function() {
			 				doneCallBack(param1);		
			 			});
			 		} else {
			 			jqxhr.done(function() {
			 				doneCallBack();		
			 			});
			 		}
			 	}
			}
		});

    </script>