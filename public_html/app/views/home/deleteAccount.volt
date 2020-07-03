
<div class="row">
	<div class="col-sm">
		 Username: {{ account.getHostUsername() }}
	</div>
</div>
<div class="row">
	<div class="col-sm">
		 Domain: {{ account.getHostDomain() }}
	</div>
</div>

<form method="post" action="{{ baseUrl }}home/deleteAccount" autocomplete="off">

	<input type="hidden" name="id" value="{{ id }}">

	<div class="form-check">
	    <input type="checkbox" class="form-check-input" name="skipDeleteServer" id="skipDeleteServer" value="1" aria-describedby="skipDeleteServerHelp">
	    <label class="form-check-label" for="skipDeleteServer">Skip Delete From Server</label>
	    <small id="skipDeleteServerHelp" class="form-text text-muted">Will skip deleting the account from the server. Will only be removed from the database.</small>
	</div>

  <button type="submit" class="btn btn-primary">Delete Account</button>
  
</form>