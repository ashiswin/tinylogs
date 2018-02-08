<?php
    // Use this script to remove an Admin account with admin id, $id
    // $_POST requires 'id'
	require_once "utils/database.php";
	require_once "connectors/AdminConnector.php";
	
	$id = $_POST['id'];
	
	$AdminConnector = new AdminConnector($conn);
	$AdminConnector->delete($id);
	
	$response["success"] = true;
	
	echo(json_encode($response));
?>
