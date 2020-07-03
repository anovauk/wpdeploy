<form method="post" action="{{ baseUrl }}home/editUser" autocomplete="off">

  <input type="hidden" name="id" value="{{ user.getId() }}">

  <div class="form-group">
    <label for="username">Username </label>
    <input type="text" class="form-control" id="username" name="username" value="{{ user.getUsername() }}">
  </div>

  <div class="form-group">
    <label for="password">Password </label>
    <input type="text" class="form-control" id="password" name="password" placeholder="Password">
  </div>

  <div class="form-group">
    <label for="name">Name </label>
    <input type="text" class="form-control" id="name" name="name" value="{{ user.getName() }}">
  </div>

  <div class="form-group">
    <label for="email">Email </label>
    <input type="text" class="form-control" id="email" name="email" value="{{ user.getEmail() }}">
  </div>

  <div class="form-group">
    <label for="active">Active </label>
    <input type="text" class="form-control" id="active" name="active" value="{{ user.getActive() }}">
  </div>
  
  <button type="submit" class="btn btn-primary">Save</button>

</form>

<script>

  {% if successMsg %}
    toastr.success('{{ successMsg }}');
  {% endif %}
  
  {% if errorMsg %}
    {% for error in errorMsg %}
      toastr.error('{{ error }}');
    {% endfor %}
  {% endif %}

</script>