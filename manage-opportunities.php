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
		#editor {
			max-height: 250px;
			height: 600px;
			background-color: white;
			border-collapse: separate; 
			border: 1px solid rgb(204, 204, 204); 
			padding: 4px; 
			box-sizing: content-box; 
			-webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset; 
			box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
			border-top-right-radius: 3px; border-bottom-right-radius: 3px;
			border-bottom-left-radius: 3px; border-top-left-radius: 3px;
			overflow: scroll;
			outline: none;
		}
		#editEditor {
			max-height: 250px;
			height: 250px;
			background-color: white;
			border-collapse: separate; 
			border: 1px solid rgb(204, 204, 204); 
			padding: 4px; 
			box-sizing: content-box; 
			-webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset; 
			box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
			border-top-right-radius: 3px; border-bottom-right-radius: 3px;
			border-bottom-left-radius: 3px; border-top-left-radius: 3px;
			overflow: scroll;
			outline: none;
		}
		#voiceBtn {
			width: 20px;
			color: transparent;
			background-color: transparent;
			transform: scale(2.0, 2.0);
			-webkit-transform: scale(2.0, 2.0);
			-moz-transform: scale(2.0, 2.0);
			border: transparent;
			cursor: pointer;
			box-shadow: none;
			-webkit-box-shadow: none;
		}

		div[data-role="editor-toolbar"] {
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		.dropdown-menu a {
			cursor: pointer;
		}

	</style>
	<?php require_once 'nav.php' ?>
	<div class="container">
		<img id="largeLogo" src="../img/prowiz-transparent.png" style="margin-top: 2%" />
		<div class="row">
			<div class="col-md-12">
				<br>
				<h1 style="text-align: center">Manage Opportunities</h1>
				<hr>
				<form class="form-horizontal" id="frmIntro">
					<div class="form-group">
						<label for="txtIntro" class="col-md-2">Intro:</label>
						<div class="col-md-12">
							<textarea class="form-control" id="txtIntro" rows="6"><?php echo file_get_contents("../data/opportunities-intro.txt"); ?></textarea>
						</div>
					</div>
					<div>
						<button class="btn btn-primary float-md-right" id="btnIntroSubmit" style="margin-right: 1%">Save</button>
					</div>
				</form>
				<br>
				<form class="form-horizontal" id="frmProgramme">
					<h3>Add an opportunity</h3>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtTitle" class="col-md-2">Title:</label>
							<div class="col-md-12">
								<input class="form-control" type="text" id="txtTitle">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtSummary" class="col-md-2">Summary:</label>
							<div class="col-md-12">
								<textarea class="form-control" id="txtSummary" rows="4"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtDescription" class="col-md-2">Description:</label>
							<div class="row col-md-12">
								<div class="btn-toolbar col-md-6" data-role="editor-toolbar" data-target="#editor" id="toolbar">
									<div class="btn-group">
										<a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font" aria-hidden="true"></i><b class="caret"></b></a>
										<ul class="dropdown-menu">
										</ul>
									</div>
									<div class="btn-group">
										<a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height" aria-hidden="true"></i><b class="caret"></b></a>
										<ul class="dropdown-menu">
										<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
										<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
										<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
										</ul>
									</div>
									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold" aria-hidden="true"></i></a>
										<a class="btn btn-secondary" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic" aria-hidden="true"></i></a>
										<a class="btn btn-secondary" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough" aria-hidden="true"></i></a>
										<a class="btn btn-secondary" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline" aria-hidden="true"></i></a>
									</div>
									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
										<a class="btn btn-secondary" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
										<a class="btn btn-secondary" data-edit="indent" title="Increase indent (Tab)"><i class="fa fa-indent"></i></a>
									</div>
								</div>
								<div class="btn-toolbar col-md-6" data-role="editor-toolbar" data-target="#editor" id="toolbar">
									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
										<a class="btn btn-secondary" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
										<a class="btn btn-secondary" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
										<a class="btn btn-secondary" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
									</div>

									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
										<a class="btn btn-secondary" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
									</div>
									<input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
								</div>
							</div>
							<div class="col-md-12">
								<div id="editor">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary float-md-right" id="btnSubmit" style="margin-right: 1%">Create</button>
						</div>
					</div>
				</form>
				<hr>
				<h3>Existing opportunities</h3>
				<br>
				<table class="table table-hover" id="tblOpportunities">
				</table>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="mdlEdit">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit opportunity</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtTitle" class="col-md-2">Title:</label>
							<div class="col-md-12">
								<input class="form-control" type="text" id="txtEditTitle">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtSummary" class="col-md-2">Summary:</label>
							<div class="col-md-12">
								<textarea class="form-control" id="txtEditSummary" rows="4"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="txtDescription" class="col-md-2">Description:</label>
							<div class="row col-md-12">
								<div class="btn-toolbar col-md-12" data-role="editor-toolbar-modal" data-target="#editEditor">
									<div class="btn-group">
										<a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font" aria-hidden="true"></i><b class="caret"></b></a>
										<ul class="dropdown-menu">
										</ul>
									</div>
									<div class="btn-group">
										<a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height" aria-hidden="true"></i><b class="caret"></b></a>
										<ul class="dropdown-menu">
										<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
										<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
										<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
										</ul>
									</div>
									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold" aria-hidden="true"></i></a>
										<a class="btn btn-secondary" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic" aria-hidden="true"></i></a>
										<a class="btn btn-secondary" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough" aria-hidden="true"></i></a>
										<a class="btn btn-secondary" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline" aria-hidden="true"></i></a>
									</div>
									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
										<a class="btn btn-secondary" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
										<a class="btn btn-secondary" data-edit="indent" title="Increase indent (Tab)"><i class="fa fa-indent"></i></a>
									</div>
								</div>
								<div class="btn-toolbar col-md-12" data-role="editor-toolbar-modal" data-target="#editEditor">
									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
										<a class="btn btn-secondary" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
										<a class="btn btn-secondary" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
										<a class="btn btn-secondary" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
									</div>

									<div class="btn-group">
										<a class="btn btn-secondary" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
										<a class="btn btn-secondary" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
									</div>
									<input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
								</div>
							</div>
							<div class="col-md-12">
								<div id="editEditor">
								</div>
							</div>
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
					<h5 class="modal-title">Delete opportunity</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Are you sure you want to delete this opportunity?
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
	<script src="../lib/bootstrap-wysiwyg/bootstrap-wysiwyg.js"></script>
	<script src="../lib/bootstrap-wysiwyg/external/jquery.hotkeys.js"></script>
	<script src="../lib/bootstrap-wysiwyg/external/google-code-prettify/prettify.js"></script>
	<script>
		$(function(){
			function initToolbarBootstrapBindings() {
				var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
					'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
					'Times New Roman', 'Verdana'],
				fontTarget = $('[title=Font]').siblings('.dropdown-menu');
				$.each(fonts, function (idx, fontName) {
					fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
				});
		
				$('#toolbar a[title]').tooltip({container:'body'});
				$('.dropdown-menu input').click(function() {return false;})
				.change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
				.keydown('esc', function () {this.value='';$(this).change();});

				$('[data-role=magic-overlay]').each(function () { 
					var overlay = $(this), target = $(overlay.data('target')); 
					overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
				});
				if ("onwebkitspeechchange"  in document.createElement("input")) {
					var editorOffset = $('#editor').offset();
					$('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
				} else {
					$('#voiceBtn').hide();
				}
			};
		
			initToolbarBootstrapBindings();
		});
	</script>
	<script type="text/javascript">
		var opportunities = null;
		var editing = -1;
		var deleting = -1;
		function saveIntro() {
			$.post("../scripts/SaveOpportunitiesIntro.php", { intro: $("#txtIntro").val() }, function(data){
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
		
		function loadOpportunities() {
			$.get("../scripts/GetOpportunities.php", function(data) {
				var response = JSON.parse(data);
				if(response.success) {
					opportunities = response.opportunities;
					
					var opportunitiesTable = "<thead><tr><th>#</th><th>Title</th><th>Summary</th><th><i class=\"fa fa-pencil\"></i></th><th><i class=\"fa fa-trash\"></i></th></tr></thead><tbody>";
					for(var i = 0; i < response.opportunities.length; i++) {
						opportunitiesTable += "<tr>";
						opportunitiesTable += "<th scope=\"row\">" + (i + 1) + "</th>";
						opportunitiesTable += "<td>" + response.opportunities[i].title + "</td>";
						opportunitiesTable += "<td>" + response.opportunities[i].summary + "</td>";
						opportunitiesTable += "<td><a href=\"#\" class=\"edit\" id=\"" + i + "\"><i class=\"fa fa-pencil\"></i></a></td>";
						opportunitiesTable += "<td><a href=\"#\" class=\"delete\" id=\"" + i + "\"><i class=\"fa fa-trash\"></i></a></td>";
						opportunitiesTable += "</tr>";
					}
					opportunitiesTable += "</tbody>";
					$("#tblOpportunities").html(opportunitiesTable);
					
					$(".edit").click(function(e) {
						e.preventDefault();
						var id = $(this).attr('id');
						
						$("#mdlEdit").modal();
						$("#txtEditTitle").val(opportunities[id].title);
						$("#txtEditSummary").val(opportunities[id].summary);
						$("#editEditor").html(opportunities[id].description);
						
						editing = opportunities[id].id;
					});
					$(".delete").click(function(e) {
						e.preventDefault();
						var id = $(this).attr('id');
						
						$("#mdlDelete").modal();
						
						deleting = opportunities[id].id;
					});
				}
			});
		}
		
		$(document).ready(function() {
			$("#navOpportunities").addClass('active');
			$('#editor').wysiwyg();
			$('#editEditor').wysiwyg({ toolbarSelector: '[data-role=editor-toolbar-modal]' });
			loadOpportunities();
			
			$("#btnDelete").click(function(e) {
				e.preventDefault();
				$.post("../scripts/DeleteOpportunity.php", { id: deleting }, function(data){
					response = JSON.parse(data); // gets response from the PHP script, if any

					if(response.success){
						$("#mdlDelete").modal('hide');
						loadOpportunities();
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
				var title = $("#txtTitle").val();
				var summary = $("#txtSummary").val();
				var description = $("#editor").cleanHtml();
				var form_data = new FormData();
				
				form_data.append('title', title);
				form_data.append('summary', summary);
				form_data.append('description', description);
				
				$.ajax({
				url: '../scripts/AddOpportunity.php', // point to server-side PHP script 
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
							$("#editor").html("");
							$("#btnSubmit").html("Create");
							$("#btnSubmit").prop('disabled', false);
							loadOpportunities();
						} else{
							$("#txtTitle")[0].setCustomValidity(response.message);
							$("#txtTitle")[0].reportValidity();
						}
					}
				});
			});
			$("#btnEditSave").click(function(e) {
				e.preventDefault();
				$(this).html("<i class='fa fa-refresh spinning'></i> Saving");
				$(this).prop('disabled', true);
				
				e.preventDefault();
				var title = $("#txtEditTitle").val();
				var summary = $("#txtEditSummary").val();
				var description = $("#editEditor").cleanHtml();
				var form_data = new FormData();
				
				form_data.append('id', editing);
				form_data.append('title', title);
				form_data.append('summary', summary);
				form_data.append('description', description);
				
				$.ajax({
				url: '../scripts/UpdateOpportunity.php', // point to server-side PHP script 
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(data){
						response = JSON.parse(data); // gets response from the PHP script, if any

						if(response.success){
							$("#mdlEdit").modal('hide');
							$("#btnEditSave").html("Save");
							$("#btnEditSave").prop('disabled', false);
							loadOpportunities();
						} else{
							$("#txtEditTitle")[0].setCustomValidity(response.message);
							$("#txtEditTitle")[0].reportValidity();
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
