<?php
	class AdminConnector {
		private $mysqli = NULL;
		
		public static $TABLE_NAME = "admins";
		public static $COLUMN_ID = "id";
		public static $COLUMN_USERNAME = "username";
		public static $COLUMN_PASSWORD = "password";
		public static $COLUMN_NAME = "name";
		public static $COLUMN_SALT = "salt";
		public static $COLUMN_EMAIL = "email";
		
        // The prepare statements exist to prevent SQL injection
		private $createStatement = NULL;
		private $selectStatement = NULL;
		private $selectByIdStatement = NULL;
		private $selectAllStatement = NULL;
		private $deleteStatement = NULL;
		
		function __construct($mysqli) {
            // This class requires utils/database.php
            // The input to the constructor is a handle to the sql session. Should be $conn
			if($mysqli->connect_errno > 0){
				die('Unable to connect to database [' . $mysqli->connect_error . ']');
			}
			
			$this->mysqli = $mysqli;
			
            // createStatement creates a new admin
			$this->createStatement = $mysqli->prepare("INSERT INTO " . AdminConnector::$TABLE_NAME . "(`" . AdminConnector::$COLUMN_USERNAME . "`, `" . AdminConnector::$COLUMN_PASSWORD . "`, `" . AdminConnector::$COLUMN_SALT . "`, `" . AdminConnector::$COLUMN_NAME . "`, `" . AdminConnector::$COLUMN_EMAIL . "`) VALUES(?, ?, ?, ?, ?)");
			
            // selectStatement searches for an admin of the input username
            $this->selectStatement = $mysqli->prepare("SELECT * FROM `" . AdminConnector::$TABLE_NAME . "` WHERE `" . AdminConnector::$COLUMN_USERNAME . "` = ?");
			
            // selectByIdStatement searches for an admin of the input Id. This is faster than selectStatement
            $this->selectByIdStatement = $mysqli->prepare("SELECT * FROM `" . AdminConnector::$TABLE_NAME . "` WHERE `" . AdminConnector::$COLUMN_ID . "` = ?");
			
            // selectAllStatement just grabs every admin account from the server
            $this->selectAllStatement = $mysqli->prepare("SELECT * FROM `" . AdminConnector::$TABLE_NAME . "`");
			
            // deleteStatement, you guess it! Deletes an admin account of input id
            $this->deleteStatement = $mysqli->prepare("DELETE FROM " . AdminConnector::$TABLE_NAME . " WHERE `" . AdminConnector::$COLUMN_ID . "` = ?");
		
            // updateStatement updates the password of the input admin id
            $this->updateStatement = $mysqli->prepare("UPDATE " . AdminConnector::$TABLE_NAME . " SET `" . AdminConnector::$COLUMN_PASSWORD . "` = ?, `" . AdminConnector::$COLUMN_SALT . "` = ? WHERE `" . AdminConnector::$COLUMN_ID . "` = ?");
                
        }
		
		public function create($username, $passwordHash, $salt, $name, $email) {
            // Create new admin using username, hashed password, salt and name of the person
			if($username == NULL) return false; // if you didn't enter a username, the method stops
			
			$this->createStatement->bind_param("sssss", $username, $passwordHash, $salt, $name, $email);
			return $this->createStatement->execute();
		}
		
		public function select($username) {
            // Select the admin account of input username
			if($username == NULL) return false; // if you didn't enter a username, the method stops
			
			$this->selectStatement->bind_param("s", $username);
			if(!$this->selectStatement->execute()) return false; // if the query didn't execute, return false

			$result = $this->selectStatement->get_result();
			if(!$result) return false; // if the query didn't give a result, return false
			$admin = $result->fetch_assoc();
			
			$this->selectStatement->free_result(); // releases memory
			
			return $admin;
		}
        
		public function selectById($adminid) {
            // Select the admin account of admin id
			$this->selectByIdStatement->bind_param("i", $adminid);
			if(!$this->selectByIdStatement->execute()) return false; // if the query didn't execute, return false

			$result = $this->selectByIdStatement->get_result();
			if(!$result) return false; // if the query didn't give a result, return false
			$admin = $result->fetch_assoc();
			
			$this->selectByIdStatement->free_result(); // releases memory
			
			return $admin;
		}
		public function selectAll() {
            // Grab everything from the table
			if(!$this->selectAllStatement->execute()) return false; // if the query didn't execute, return false
			$result = $this->selectAllStatement->get_result(); // frees memory
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);
			return $resultArray;
		}
		
		public function updatePassword($password, $salt, $adminid) {
            // Updates admin password of admin id
            // $password should have been hashed before calling this function
			$this->updateStatement->bind_param("ssi", $password, $salt, $adminid);
			
			if(!$this->updateStatement->execute()) return false; // if the query didn't execute, return false
			return true;
		}
		
		public function delete($id) {
            // Deletes admin account of id
			$this->deleteStatement->bind_param("i", $id);
			if(!$this->deleteStatement->execute()) return false; // if the query didn't execute, return false
			
			return true;
		}
	}
?>
