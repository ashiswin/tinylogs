<?php
    // Use this script to create a default admin account
   	require_once 'utils/random_gen.php';
	require_once 'utils/database.php';
	require_once 'connectors/AdminConnector.php';
	
	$AdminConnector = new AdminConnector($conn);
	$username = "admin";
	$salt = random_str(10);
	$password = hash('sha512', ("password" . $salt));
	$name = "admin";
	$email = "ashiswin@gmail.com";
	$result = $AdminConnector->create($username, $password, $salt, $name, $email);
	
    if(!$result) {
		$response["message"] = "Invalid username or password!";
		$response["error"] = true;
		$response["success"] = false;
	}
	else {	
		$response["success"] = true;
		$response["error"] = false;
	}
	
	echo(json_encode($response));
?>
