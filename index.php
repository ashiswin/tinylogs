<?php
	// Begin PHP session
	session_start();
	// Auto-redirect to management page if already logged in
	if(isset($_SESSION['adminid'])) {
		header("Location: dashboard.php");
	}
?>
<html>
<head>
	<title>Login to ProWiz</title>
	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	
</head>
<body>
	<style>
		nav {
			position: fixed;
		}
		.navbar {
			margin-bottom: 0;
		}
		.glyphicon.spinning {
			animation: spin 1s infinite linear;
			-webkit-animation: spin2 1s infinite linear;
		}
		@keyframes spin {
			from { transform: scale(1) rotate(0deg); }
			to { transform: scale(1) rotate(360deg); }
		}
		@-webkit-keyframes spin2 {
			from { -webkit-transform: rotate(0deg); }
			to { -webkit-transform: rotate(360deg); }
		}
		.indent {
			text-indent: 5%;
		}
	</style>
	<!-- Begin navigation bar-->
	<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="/"><img src="../img/prowiz-transparent.png" height="30" /></a>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li id="navContact" class="nav-item"><a href="/" class="nav-link">Log In</a></li>
			</ul>
		</div>
	</nav>
	
	<!-- Main container -->
	<div class="container" style="margin-top: 2%">
		<div class="row"> <!-- Place all elements on same row -->
			<div class="col-md-4 offset-md-4"> <!-- Use middle third of screen -->
				<div class="card"> <!-- Create a panel -->
				  	<div class="card-block"> <!-- Create panel content -->
						<h4 class="card-title">Please sign in to Tinylogs</h4>
						<!-- Create login form -->
					    	<form accept-charset="UTF-8" role="form" id="loginform" method="post" action="manage-about.php">
							<!-- Create form elements -->
				    			<fieldset>
						    	  	<div class="form-group">
						    		    <input class="form-control" placeholder="Username" name="username" id="username" type="text">
						    		</div>
						    		<div class="form-group">
						    			<input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
						    		</div>
								<input type="hidden" id="adminid" name="adminid" /> <!-- Hidden input is used to transmit admin ID to the next page to be stored in session -->
						    		<button class="btn btn-primary btn-block" type="submit" data-loading-text="<i class='glyphicon glyphicon-refresh spinning'></i> Loading..." id="btnLogin">Login</button>
					    		</fieldset>
					      	</form>
				    	</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- jQuery library -->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
	
	<script type="text/javascript">
		$("#btnLogin").click(function(e) {
			e.preventDefault(); // Override default form submission
			// Manually post data to login script
			$.post("scripts/AdminLogin.php", { username: $("#username").val(), password: $("#password").val() }, function(data) {
				response = JSON.parse(data); // Convert to JSON
				if(!response.success) { // Check if authentication succeeded
					if(response.error) {
						$("#username")[0].setCustomValidity(response.message);
						$("#username")[0].reportValidity();
						$("#btnLogin").button('reset');
					}
				}
				else {
					$("#adminid").val(response.adminid) // Set hidden element with admin ID
					document.getElementById("loginform").submit(); // Submit the HTML form manually
				}
			});
		});
	</script>
</body>
</html>
