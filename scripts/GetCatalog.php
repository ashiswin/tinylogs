<?php
	require_once 'scripts/utils/database.php';
	require_once 'scripts/connectors/CatalogConnector.php';
	
	$CatalogConnector = new CatalogConnector($conn);
	$items = $CatalogConnector->selectAll();
	
	$response["items"] = $items;
	$response["success"] = true;
	
	echo(json_encode($response));
?>
