<?php
	// Begin PHP session
	session_start();
	if(isset($_POST['adminid'])) {
		$_SESSION['adminid'] = $_POST['adminid'];
	}
	// Auto-redirect to management page if already logged in
	if(!isset($_SESSION['adminid'])) {
		header("Location: /admin/");
	}
?>
<html>
<head>
	<title>Manage ProWiz</title>
	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://use.fontawesome.com/1c64219ae2.js"></script>
</head>
<body>
	<style>
		nav {
			position: fixed;
		}
		.navbar {
			margin-bottom: 0;
		}
		.spinning {
			animation: spin 1s infinite linear;
			-webkit-animation: spin2 1s infinite linear;
		}
		#largeLogo {
			display: block;
			margin: auto;
			width: 40%;
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
	<?php require_once 'nav.php' ?>
	<div class="container" style="margin-top: 2%">
		<img id="largeLogo" src="../img/prowiz-transparent.png" style="margin-top: 2%" />
		<br>
		<h1 style="text-align: center">Manage About Us</h1>
		<hr>
		<br>
		<div class="col-md-12">
			<form class="form-horizontal offset-md-1 col-md-10" id="frmAbout">
				<div class="form-group col-md-12">
					<label for="txtProfile" class="col-md-2">Profile:</label>
					<div class="col-md-12">
						<textarea class="form-control" id="txtProfile" rows="6"><?php echo file_get_contents("../data/about-profile.txt"); ?></textarea>
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="txtMission" class="col-md-2">Mission:</label>
					<div class="col-md-12">
						<textarea class="form-control" id="txtMission" rows="6"><?php echo file_get_contents("../data/about-mission.txt"); ?></textarea>
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="txtVision" class="col-md-2">Vision:</label>
					<div class="col-md-12">
						<textarea class="form-control" id="txtVision" rows="6"><?php echo file_get_contents("../data/about-vision.txt"); ?></textarea>
					</div>
				</div>
				<div class="col-md-12">
					<button class="btn btn-primary float-md-right" id="btnSubmit" style="margin-right: 2%">Save</button>
				</div>
				<br>
			</form>
		</div>
	</div>
</body>
<!-- jQuery library -->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
	
	<script type="text/javascript">
		function saveAbout() {
			$.post("../scripts/SaveAbout.php", { profile: $("#txtProfile").val(), mission: $("#txtMission").val(), vision: $("#txtVision").val() }, function(data){
				response = JSON.parse(data); // gets response from the PHP script, if any

				if(response.success){
					$("#btnSubmit").html("<i class='fa fa-check'></i> Saved");
					$("#btnSubmit").removeClass("btn-primary");
					$("#btnSubmit").addClass("btn-success");
					$("#btnSubmit").prop('disabled', false);
					setTimeout(function() {
						$("#btnSubmit").addClass("btn-primary");
						$("#btnSubmit").removeClass("btn-success");
						$("#btnSubmit").html("Save");
					}, 2000);
				} else{
					console.log(response.error);
				}
			});
		}
		
		$(document).ready(function() {
			$("#navAbout").addClass('active');
			
			$("#btnSubmit").click(function(e) {
				e.preventDefault();
				$(this).html("<i class='fa fa-refresh spinning'></i> Saving");
				$(this).prop('disabled', true);
				saveAbout();
			});
		});
	</script>
</html>
