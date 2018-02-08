<?php
	// Use this script when you want to update admin account's password
    // $_POST requires adminid, current password and new password

	$adminid = trim($_POST['adminid']);
	$current = trim($_POST['current']);
	$newPass = trim($_POST['newpass']);
	
	$response = array();
	
    require_once 'utils/random_gen.php';
	require_once 'utils/database.php';
	require_once 'connectors/AdminConnector.php';
	
	$AdminConnector = new AdminConnector($conn);
	$result = $AdminConnector->selectById($adminid); // Find the row in database for this adminid

	if(!$result) { // If the row can't be found
		$response["message"] = "Uable to select admin";
		$response["error"] = true;
		$response["success"] = false;
		
		echo(json_encode($response));
		return;
	}
	
	$passwordHash = hash('sha512', ($current . $result[AdminConnector::$COLUMN_SALT]));
	if(!strcmp($passwordHash, $result[AdminConnector::$COLUMN_PASSWORD]) == 0) { // Check if current password is correct
		$response["success"] = false;
		$response["error"] = true;
		$response["message"] = "Invalid username or password!";
		
		echo(json_encode($response));
		return;
	}
	
	$salt = random_str(10); // Generate new salt
	$password = hash('sha512', ($newPass . $salt)); // Hash the new password
	
	if(!$AdminConnector->updatePassword($password, $salt, $adminid)) { // Update the password
		$response["message"] = "An error occurred while updating password";
		$response["success"] = false;
	}
	else {
		$response["success"] = true;
	}
	
	echo(json_encode($response));
?>
