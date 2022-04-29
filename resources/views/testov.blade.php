<!DOCTYPE html>
<html>
<head>
		<link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script src="https://kit.fontawesome.com/ee1e499696.js" crossorigin="anonymous" integrity="sha384-p7JrABPXxZLpj1XoHTzkPyVs8ekVssRFXc4B7XU6Z1c8XVDA7sVPem/lQ9UouxqE"></script>
		
		<link rel="stylesheet" type="text/css" href="https://mywinrideshare.com/css/xflow.css">
		
		<script src="https://mywinrideshare.com/js/xflow/remote.js"></script>
		<script src="https://mywinrideshare.com/js/xflow/x.min.js"></script>

	</head>
	<body style="background-color: transparent">
		<div class="col-md-8">

<div id="user_profile_div" class="xflow-widget" style="width: 300px; height:400px;"
	data-status="active"
	data-menu="ewallet"
	data-action="summary"
	data-spinner="1"
	data-post="userid={{$userid}}&currency_id=1">
</div>


		</div>
              
		<script>
                        const user = @json($url);   
			window.is_app = true;
			$(document).ready(function() {	
                            XFlow.widget.remote(user);
			});
		</script>
	</body>
</html>
