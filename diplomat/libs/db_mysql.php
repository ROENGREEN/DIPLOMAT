<?php
namespace diplomat;

class Mysql {
	var $servername = "localhost";
	var $username = "root";
	var $password = "ehsqjfwk";
	var $dbname = "DIPLOMAT";
	var $conn;
	
	var $blockColumn = array("idx", "created_time", "updated_time");
	var $error;

	function __construct() {
		$this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
		// Check connection
		if (!$this->conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
	}
	
	function __destruct() {
		mysqli_close($this->conn);
	}
	
	function __set_error( $error ) {
		$this->error = $error;
	}
	
	function __query( $sql ) {		
		if ($result = mysqli_query($this->conn, $sql)) {
			//echo "Table created successfully";
			return $result;
		} else {
			$this->error = "Error creating table: " . mysqli_error($this->conn);
			return false;
		}
	}
	
	function __table_exists( $tableName ) {
		$sql = "SHOW TABLES LIKE '{$tableName}'";
		$result = $this->__query($sql);
		if ( mysqli_num_rows( $result ) )
			return true;
		else
			return false;
	}
	
	public function create( $data ) {
		// sql to create table
		$sql = "CREATE TABLE {$data['table']} (
			idx BIGINT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
		
		foreach ( $data as $key=>$value ) {
			if ( in_array($key, $this->blockColumn) ) {
				$this->error = "user blocked column";
				return false;
			} else if ( $key == 'table' )
				continue;
			$sql .= "{$key} VARCHAR(1000),";
		}
		
		$sql .= "created_time INT(11),
			updated_time INT(11)
			)";
		
		$result = $this->__query( $sql );
		return $result;
	}
	
	public function insert( $data ) {
		if ( !is_array( $data ) || !isset( $data['table'] ) ) {
			$this->error = "don't set table";
			return false;
		}
		
		if ( !$this->__table_exists( $data['table'] ) && !$this->create( $data ) ) {
			//$this->error = "create error";
			return false;
		}
		
		$sql = "INSERT INTO {$data['table']} (created_time";
		$values = " VALUES (" . time();
		foreach ( $data as $key=>$value ) {
			if ( $key == 'table')
				continue;
			$sql .= ",{$key}";
			$values .= ",'{$value}'";
		}
		$sql .= ") {$values})";
		$result = $this->__query($sql);
		
		return $result;
	}
}

?>