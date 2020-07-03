<form method="post" action="{{ baseUrl }}home/addUser" autocomplete="off">

  <div class="form-group">
    <label for="username">Username </label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
  </div>

  <div class="form-group">
    <label for="password">Password </label>
    <input type="text" class="form-control" id="password" name="password" placeholder="Password">
  </div>

  <div class="form-group">
    <label for="name">Name </label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
  </div>

  <div class="form-group">
    <label for="email">Email </label>
    <input type="text" class="form-control" id="email" name="email" placeholder="EMail">
  </div>

  <div class="form-group">
    <label for="active">Active </label>
    <input type="text" class="form-control" id="active" name="active" placeholder="Y or N">
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