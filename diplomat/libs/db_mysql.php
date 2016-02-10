<?php
namespace diplomat;

class Mysql {
	var $servername = "localhost";
	var $username = "root";
	var $password = "ehsqjfwk";
	var $dbname = "DIPLOMAT";
	var $conn;
	
	var $blockColumn = array("table", "idx", "created_time", "updated_time", "create", "select", "update", "delete", 
			"from", "set", "where", "join", "in", "like", "order", "group", "limit", "offset");
	var $skipColumn = array("redirect_url");
	var $error;
	var $segment;
	var $table;

	function __construct( $config ) {
		$this->servername = $config['servername'];
		$this->username = $config['id'];
		$this->password = $config['pass'];
		$this->dbname = $config['database'];
		
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
	
	function __get_columns( $tableName ) {
		$sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='{$this->dbname}' AND TABLE_NAME='{$tableName}'";
		return $this->__query($sql);
	}
	
	function __is_correct_columns( $data ) {
		$notExistColumns = array();
		$columns = $this->__get_columns( $this->table );
		foreach ( $data as $key=>$value ) {
			$notExist = true;
			foreach ( $columns as $c )
				if ( $c['COLUMN_NAME'] == $key ) {
					$notExist = false;
					break;
				}
			if ( $notExist )
				$notExistColumns[] = $key;
		}

		if ( count( $notExistColumns ) ) {
			$this->error = "not exist column : " . implode(",", $notExistColumns);
			return false;
		}
		
		return true;
	}
	
	function __getTable() {
		$filePath = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
		$segments = substr( $_SERVER['PHP_SELF'], strpos( $_SERVER['PHP_SELF'], $filePath ) + strlen( $filePath ) );
		if ( $segments && strlen($segments) > 0 && $segments[0] == "/" )
			$segments = substr( $segments, 1 );
		$this->segments = explode('/', $segments);
		if ( $this->segments && count( $this->segments ) > 0 && $this->segments[0] != "" )
			$this->table = $this->segments[0];
	}
	
	public function create( $data ) {
		// sql to create table
		$sql = "CREATE TABLE {$this->table} (
			idx BIGINT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
		
		foreach ( $data as $key=>$value ) {			
			if ( in_array(str_replace(" ", "", $key), $this->blockColumn) ) {
				$this->error = "user blocked column";
				return false;
			}
			
			if ( is_numeric( $value ) )
				$value += 0;
			
			if ( is_int( $value ) )
				$sql .= "{$key} INT(11),";
			else if ( is_float( $value ) )
				$sql .= "{$key} DOUBLE(20,10),";
			else
				$sql .= "{$key} VARCHAR(1000),";
		}
		
		$sql .= "created_time INT(11),
			updated_time INT(11)
			)";
		
		$result = $this->__query( $sql );
		return $result;
	}
	
	public function insert( ) { 
		$this->__getTable();
		
		if ( $this->table == "" ) {
			$this->error = "don't set table";
			return false;
		}
		
		$data = array();
		foreach ( $_REQUEST as $key=>$value )
			if ( !in_array(str_replace(" ", "", $key), $this->skipColumn) )
				$data[$key] = $value;
		
		if ( !$this->__table_exists( $this->table ) && !$this->create( $data ) ) {
			//$this->error = "create error";
			return false;
		}
		
		if ( !$this->__is_correct_columns( $data ) ) {
			return false;
		}
		
		$sql = "INSERT INTO {$this->table} (created_time";
		$values = " VALUES (" . time();
		foreach ( $data as $key=>$value ) {
			$sql .= ",{$key}";
			$values .= ",'{$value}'";
		}
		$sql .= ") {$values})";
		$result = $this->__query($sql);
		
		return $result;
	}
}

?>