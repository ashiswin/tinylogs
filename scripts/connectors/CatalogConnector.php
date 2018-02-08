<?php
	class CatalogConnector {
		private $mysqli = NULL;
		
		public static $TABLE_NAME = "catalog";
		public static $COLUMN_ID = "id";
		public static $COLUMN_STOCK = "stock";
		public static $COLUMN_NAME = "name";
		public static $COLUMN_PRICE = "price";
		public static $COLUMN_SUPPLIER = "supplier";
		
        // The prepare statements exist to prevent SQL injection
		private $createStatement = NULL;
		private $selectStatement = NULL;
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
			$this->createStatement = $mysqli->prepare("INSERT INTO " . CatalogConnector::$TABLE_NAME . "(`" . CatalogConnector::$COLUMN_NAME . "`, `" . CatalogConnector::$COLUMN_STOCK . "`, `" . CatalogConnector::$COLUMN_PRICE . "`, `" . CatalogConnector::$COLUMN_SUPPLIER . "`) VALUES(?, ?, ?, ?)");
			
            // selectStatement searches for an admin of the input username
            $this->selectStatement = $mysqli->prepare("SELECT * FROM `" . CatalogConnector::$TABLE_NAME . "` WHERE `" . CatalogConnector::$COLUMN_ID . "` = ?");
	
            // selectAllStatement just grabs every admin account from the server
            $this->selectAllStatement = $mysqli->prepare("SELECT * FROM `" . CatalogConnector::$TABLE_NAME . "`");
			
            // deleteStatement, you guess it! Deletes an admin account of input id
            $this->deleteStatement = $mysqli->prepare("DELETE FROM " . CatalogConnector::$TABLE_NAME . " WHERE `" . CatalogConnector::$COLUMN_ID . "` = ?");
		}
		
		public function create($name, $stock, $price, $supplier) {
			$this->createStatement->bind_param("ssds", $name, $stock, $price, $supplier);
			return $this->createStatement->execute();
		}
		
		public function select($id) {
			$this->selectByIdStatement->bind_param("i", $id);
			if(!$this->selectByIdStatement->execute()) return false; // if the query didn't execute, return false

			$result = $this->selectByIdStatement->get_result();
			if(!$result) return false; // if the query didn't give a result, return false
			$item = $result->fetch_assoc();
			
			$this->selectByIdStatement->free_result(); // releases memory
			
			return $item;
		}
		public function selectAll() {
            // Grab everything from the table
			if(!$this->selectAllStatement->execute()) return false; // if the query didn't execute, return false
			$result = $this->selectAllStatement->get_result(); // frees memory
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);
			return $resultArray;
		}
		public function delete($id) {
            // Deletes admin account of id
			$this->deleteStatement->bind_param("i", $id);
			if(!$this->deleteStatement->execute()) return false; // if the query didn't execute, return false
			
			return true;
		}
	}
?>
