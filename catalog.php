<?php
	// Begin PHP session
	session_start();
	if(isset($_POST['adminid'])) {
		$_SESSION['adminid'] = $_POST['adminid'];
	}
	// Auto-redirect to management page if already logged in
	if(!isset($_SESSION['adminid'])) {
		header("Location: /");
	}
?>
<html>
<head>
	<title>TinyLogs - Catalog</title>
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
	<div class="container-fluid" style="margin-top: 2%">
		<div class="row">
			<div class="col-md-8">
				<h1>Total line items: <span id="txtItems"></span></h1>
			</div>
			<div class="col-md-4">
				<button id="btnAddItem" class="btn btn-primary"><i class="fa fa-plus"></i> Add item</button>
			</div>
		</div>
		<table class="table" style="margin-top: 2vh">
			<colgroup>
				<col span="1" style="width: 5%;">
				<col span="1" style="width: 10%;">
				<col span="1" style="width: 30%;">
				<col span="1" style="width: 10%;">
				<col span="1" style="width: 10%;">
				<col span="1" style="width: 30%;">
				<col span="1" style="width: 5%;">
			</colgroup>
			<thead>
				<tr>
					<th>#</th>
					<th>Item ID</th>
					<th>Name</th>
					<th>Stock</th>
					<th>Price</th>
					<th>Supplier</th>
					<th><i class="fa fa-pencil"></i></th>
				</tr>
			</thead>
			<tbody id="tblItems">
			</tbody>
		</table>
	</div>
</body>
<!-- jQuery library -->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("#navCatalog").addClass('active');
			
			$.get("scripts/GetCatalog.php", function(data) {
				response = JSON.parse(data); // Convert to JSON
				if(!response.success) {
					var tblItems = "";
					
					for(var i = 0; i < response.items.length; i++) {
						tblItems += "<tr>";
						tblItems += "<td>" + (i + 1) + "</td>";
						tblItems += "<td>" + response.items[i].id + "</td>";
						tblItems += "<td>" + response.items[i].name + "</td>";
						tblItems += "<td>" + response.items[i].stock + "</td>";
						tblItems += "<td>$" + response.items[i].price + "</td>";
						tblItems += "<td>" + response.items[i].supplier + "</td>";
						tblItems += "<td><i class=\"fa fa-pencil\"></i></td>";
						tblItems += "</tr>";
					}
					
					$("#tblItems").html(tblItems);
					$("#txtItems").html(response.items.length);
				}
			});
		});
	</script>
</html>
