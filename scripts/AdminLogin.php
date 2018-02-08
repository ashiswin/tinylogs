<?php
    // Call this script when someone is loging in
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	$response = array();
	
	require_once 'utils/database.php'; // Provides handle to sql session
	require_once 'connectors/AdminConnector.php'; // Gives all the functions related to Admin
	
	$AdminConnector = new AdminConnector($conn);
	$result = $AdminConnector->select($username); // Check if username exists in Database

	if(!$result) { // If it doesn't exist
		$response["message"] = "Invalid username or password!";
		$response["error"] = true;
		$response["success"] = false;
	}
	else { // Check if password is correct
		$passwordHash = hash('sha512', ($password . $result[AdminConnector::$COLUMN_SALT]));
		if(strcmp($passwordHash, $result[AdminConnector::$COLUMN_PASSWORD]) == 0) { // If password matches
			$response["success"] = true;
			$response["error"] = false;
			$response["adminid"] = $result[AdminConnector::$COLUMN_ID]; // Record the admin id
		}
		else { // If password does not match
			$response["success"] = false;
			$response["error"] = true;
			$response["message"] = "Invalid username or password!";
		}
	}
	
	echo(json_encode($response)); // return a response
?>
