{# app/views/index.volt #}

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    {{ get_title() }}
    <!-- Bootstrap -->
    <link href="{{ baseUrl }}public/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Bootstrap Tables -->
    <link href="{{ baseUrl }}public/bower_components/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet">
    <!-- Toastr -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Jquery UI CSS -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <!-- https://select2.org/getting-started/installation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <!-- https://datatables.net/ -->
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <!-- Custom CSS Styles -->
    <link href="{{ baseUrl }}public/css/styles.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/2.9.0/jquery.serializejson.min.js"></script>
	<!-- Include Popper.js -->
    <script src="{{ baseUrl }}public/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="{{ baseUrl }}public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Include Toastr -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Include Bootstrap Tables Javascript -->
    <script src="{{ baseUrl }}public/bower_components/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <!-- https://select2.org/getting-started/installation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <!-- https://datatables.net/ -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- https://github.com/szimek/signature_pad -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
</head>
<body>

	<div class="container-fluid">

		{{ content() }}

		<div id="footer">	
			{{ partial("partials/footer") }}
		</div>

	</div>

</body>

</html>