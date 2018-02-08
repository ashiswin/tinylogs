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
		.hidden {
			position:absolute;
			top:-10000px;
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
	<div class="container">
		<img id="largeLogo" src="../img/prowiz-transparent.png" style="margin-top: 2%" />
		<div class="row">
			<div class="col-md-12">
				<br>
				<h1 style="text-align: center">Manage Programmes</h1>
				<hr>
				<form class="form-horizontal" id="frmIntro">
					<div class="form-group">
						<label for="txtIntro" class="col-md-2">Intro:</label>
						<div class="col-md-12">
							<textarea class="form-control" id="txtIntro" rows="6"><?php echo file_get_contents("../data/programmes-intro.txt"); ?></textarea>
						</div>
					</div>
					<div>
						<button class="btn btn-primary float-md-right" id="btnIntroSubmit" style="margin-right: 1%">Save</button>
					</div>
				</form>
				<br>
				<form class="form-horizontal" id="frmProgramme">
					<h3>Add a programme</h3>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="txtName" class="col-md-2">Name:</label>
							<div class="col-md-12">
								<input class="form-control" type="text" id="txtName">
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="txtSubtitle" class="col-md-2">Subtitle:</label>
							<div class="col-md-12">
								<input class="form-control" type="text" id="txtSubtitle">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtDescription" class="col-md-2">Description:</label>
							<div class="col-md-12">
								<textarea class="form-control" id="txtDescription" rows="6"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12" style="margin-left: 1%">
							<input type="file" class="hidden" name="imageUpload" id="imageUpload" accept="image/*">
							<a href="#" class="btn btn-success" id="btnImageUpload">Upload image</a>
					
							<input type="file" class="hidden" name="brochureUpload" id="brochureUpload" accept=".pdf">
							<a href="#" class="btn btn-success" id="btnBrochureUpload">Upload brochure</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary float-md-right" id="btnSubmit" style="margin-right: 1%">Create</button>
						</div>
					</div>
				</form>
				<hr>
				<h3>Existing programmes</h3>
				<br>
				<table class="table table-hover" id="tblProgrammes">
				</table>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="mdlEdit">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit programme</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtName" class="col-md-2">Name:</label>
							<div class="col-md-12">
								<input class="form-control" type="text" id="txtEditName">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtSubtitle" class="col-md-2">Subtitle:</label>
							<div class="col-md-12">
								<input class="form-control" type="text" id="txtEditSubtitle">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtDescription" class="col-md-2">Description:</label>
							<div class="col-md-12">
								<textarea class="form-control" id="txtEditDescription" rows="6"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12" style="margin-left: 3%">
							<input type="file" class="hidden" name="editImageUpload" id="editImageUpload" accept="image/*">
							<a href="#" class="btn btn-success" id="btnEditImageUpload">Upload image</a>
					
							<input type="file" class="hidden" name="editBrochureUpload" id="editBrochureUpload" accept=".pdf">
							<a href="#" class="btn btn-success" id="btnEditBrochureUpload">Upload brochure</a>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnEditSave">Save changes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="mdlDelete">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Delete programme</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Are you sure you want to delete this programme?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="btnDelete">Delete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- jQuery library -->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
	
	<script type="text/javascript">
		var programmes = null;
		var editing = -1;
		var deleting = -1;
		function saveIntro() {
			$.post("../scripts/SaveProgrammesIntro.php", { intro: $("#txtIntro").val() }, function(data){
				response = JSON.parse(data); // gets response from the PHP script, if any

				if(response.success){
					$("#btnIntroSubmit").html("<i class='fa fa-check'></i> Saved");
					$("#btnIntroSubmit").removeClass("btn-primary");
					$("#btnIntroSubmit").addClass("btn-success");
					$("#btnIntroSubmit").prop('disabled', false);
					setTimeout(function() {
						$("#btnIntroSubmit").addClass("btn-primary");
						$("#btnIntroSubmit").removeClass("btn-success");
						$("#btnIntroSubmit").html("Save");
					}, 2000);
				} else{
					console.log(response.error);
				}
			});
		}
		
		function loadProgrammes() {
			$.get("../scripts/GetProgrammes.php", function(data) {
				var response = JSON.parse(data);
				if(response.success) {
					programmes = response.programmes;
					
					var programmeTable = "<thead><tr><th>#</th><th>Name</th><th>Subtitle</th><th>Description</th><th>Image</th><th><i class=\"fa fa-pencil\"></i></th><th><i class=\"fa fa-trash\"></i></th></tr></thead><tbody>";
					for(var i = 0; i < response.programmes.length; i++) {
						programmeTable += "<tr>";
						programmeTable += "<th scope=\"row\">" + (i + 1) + "</th>";
						programmeTable += "<td>" + response.programmes[i].name + "</td>";
						programmeTable += "<td>" + response.programmes[i].subtitle + "</td>";
						programmeTable += "<td>" + response.programmes[i].description + "</td>";
						programmeTable += "<td>" + response.programmes[i].image + "</td>";
						programmeTable += "<td><a href=\"#\" class=\"edit\" id=\"" + i + "\"><i class=\"fa fa-pencil\"></i></a></td>";
						programmeTable += "<td><a href=\"#\" class=\"delete\" id=\"" + i + "\"><i class=\"fa fa-trash\"></i></a></td>";
						programmeTable += "</tr>";
					}
					programmeTable += "</tbody>";
					$("#tblProgrammes").html(programmeTable);
					
					$(".edit").click(function(e) {
						e.preventDefault();
						var id = $(this).attr('id');
						
						$("#mdlEdit").modal();
						$("#txtEditName").val(programmes[id].name);
						$("#txtEditSubtitle").val(programmes[id].subtitle);
						$("#txtEditDescription").html(programmes[id].description);
						$("#btnEditImageUpload").html(programmes[id].image);
						$("#btnEditBrochureUpload").html(programmes[id].name + ".pdf");
						
						editing = programmes[id].id;
					});
					$(".delete").click(function(e) {
						e.preventDefault();
						var id = $(this).attr('id');
						
						$("#mdlDelete").modal();
						
						deleting = programmes[id].id;
					});
				}
			});
		}
		
		$(document).ready(function() {
			$("#navProgrammes").addClass('active');
			loadProgrammes();
			
			$("#btnImageUpload").click(function(e) {
				e.preventDefault();
				$("#imageUpload").click();
			});
			$('#imageUpload').change(function() {
				$('#btnImageUpload').html($('#imageUpload').prop('files')[0].name);
			});
			$("#btnBrochureUpload").click(function(e) {
				e.preventDefault();
				$("#brochureUpload").click();
			});
			$('#brochureUpload').change(function() {
				$('#btnBrochureUpload').html($('#brochureUpload').prop('files')[0].name);
			});
			
			$("#btnEditImageUpload").click(function(e) {
				e.preventDefault();
				$("#editImageUpload").click();
			});
			$('#editImageUpload').change(function() {
				$('#btnEditImageUpload').html($('#editImageUpload').prop('files')[0].name);
			});
			$("#btnEditBrochureUpload").click(function(e) {
				e.preventDefault();
				$("#editBrochureUpload").click();
			});
			$('#editBrochureUpload').change(function() {
				$('#btnEditBrochureUpload').html($('#editBrochureUpload').prop('files')[0].name);
			});
			
			$("#btnDelete").click(function(e) {
				e.preventDefault();
				$.post("../scripts/DeleteProgramme.php", { id: deleting }, function(data){
					response = JSON.parse(data); // gets response from the PHP script, if any

					if(response.success){
						$("#mdlDelete").modal('hide');
						loadProgrammes();
					} else{
						console.log(response.error);
					}
				});
			});
			
			$("#btnSubmit").click(function(e) {
				e.preventDefault();
				$(this).html("<i class='fa fa-refresh spinning'></i> Creating");
				$(this).prop('disabled', true);
				
				e.preventDefault();
				var name = $("#txtName").val();
				var subtitle = $("#txtSubtitle").val();
				var description = $("#txtDescription").val();
				var imageFile = $('#imageUpload').prop('files')[0];
				var brochureFile = $('#brochureUpload').prop('files')[0];
				var form_data = new FormData();
				
				form_data.append('imageFile', imageFile);
				form_data.append('brochureFile', brochureFile);
				form_data.append('name', name);
				form_data.append('subtitle', subtitle);
				form_data.append('description', description);
				
				$.ajax({
				url: '../scripts/AddProgramme.php', // point to server-side PHP script 
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(data){
						response = JSON.parse(data); // gets response from the PHP script, if any

						if(response.success){
							$("#frmProgramme")[0].reset();
							$("#btnSubmit").html("Create");
							$("#btnSubmit").prop('disabled', false);
							$('#btnImageUpload').html("Upload image");
							$('#btnBrochureUpload').html("Upload brochure");
							loadProgrammes();
						} else{
							$("#txtName")[0].setCustomValidity(response.message);
							$("#txtName")[0].reportValidity();
						}
					}
				});
			});
			$("#btnEditSave").click(function(e) {
				e.preventDefault();
				$(this).html("<i class='fa fa-refresh spinning'></i> Saving");
				$(this).prop('disabled', true);
				
				e.preventDefault();
				var name = $("#txtEditName").val();
				var subtitle = $("#txtEditSubtitle").val();
				var description = $("#txtEditDescription").val();
				var imageFile = $('#editImageUpload').prop('files')[0];
				var brochureFile = $('#editBrochureUpload').prop('files')[0];
				var form_data = new FormData();
				
				form_data.append('id', editing);
				form_data.append('imageFile', imageFile);
				form_data.append('brochureFile', brochureFile);
				form_data.append('name', name);
				form_data.append('subtitle', subtitle);
				form_data.append('description', description);
				
				$.ajax({
				url: '../scripts/UpdateProgramme.php', // point to server-side PHP script 
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(data){
						response = JSON.parse(data); // gets response from the PHP script, if any

						if(response.success){
							$("#btnEditSave").html("Save");
							$("#btnEditSave").prop('disabled', false);
							$('#btnEditImageUpload').html("Upload image");
							$('#btnEditBrochureUpload').html("Upload brochure");
							$('#mdlEdit').modal('hide');
							loadProgrammes();
						} else{
							$("#txtEditName")[0].setCustomValidity(response.message);
							$("#txtEditName")[0].reportValidity();
						}
					}
				});
			});
			$("#btnIntroSubmit").click(function(e) {
				e.preventDefault();
				$(this).html("<i class='fa fa-refresh spinning'></i> Saving");
				$(this).prop('disabled', true);
				saveIntro();
			});
		});
	</script>
</html>
