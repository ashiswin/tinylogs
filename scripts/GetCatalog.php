<?php
	require_once 'utils/database.php';
	require_once 'connectors/CatalogConnector.php';
	
	$CatalogConnector = new CatalogConnector($conn);
	$items = $CatalogConnector->selectAll();
	
	$response["items"] = $items;
	$response["success"] = true;
	
	echo(json_encode($response));
?>
