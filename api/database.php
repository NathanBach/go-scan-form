<?php

// Config
ini_set('display_errors', 1);
error_reporting(E_ALL);

class Database {

	// specify your own database credentials
	private $__host = "localhost";
	private $__db_name = "fcr173-swt033-nathan";
	private $__username = "root";
	private $__password = "root";
	private $__conn;
	private $__table_name = "visitors";

	// get the database connection
	public function connect() {
		if (!$this->__conn) {
			$this->__conn = mysqli_connect($this->__host, $this->__username, $this->__password, $this->__db_name) or die ('Network Connection Failed');

			mysqli_query($this->__conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
		}
	}

	// Disconnect database
	public function dis_connect(){
		if ($this->__conn) {
			mysqli_close($this->__conn);
		}
	}

	// Create new record
	public function insert($sql) {
		$this->connect();

		$field_list = '';
		$value_list = '';

		// foreach ($data as $key => $value){
		// 	$field_list .= ",$key";
		// 	$value_list .= ",'".mysql_real_escape_string($value, $this->__conn)."'";
		// 	// $value_list .= ",'".mysqli_real_escape_string($this->__conn, $value)."'";
		// }
		// Remove comma after each loop
		// $sql = 'INSERT INTO '.$this->__table_name. '(section_name, form_name, user_data, insert_date) VALUES ('.trim($value_list, ',').')';

		return mysqli_query($this->__conn, $sql);
	}

	// Update record
	public function update($data, $where) {
		$this->connect();
		$sql = '';
		foreach ($data as $key => $value){
			$sql .= "$key = '".mysqli_real_escape_string($this->__conn, $value)."',";
		}

		$sql = 'UPDATE '.$this->__table_name. ' SET '.trim($sql, ',').' WHERE '.$where;

		return mysqli_query($this->__conn, $sql);
	}

	// Change delete_flag to true
	function remove($where){
		// Connect
		$this->connect();

		// Delete
		$sql = 'UPDATE ' . $this->__table_name . ' SET delete_flag = 1 WHERE ' . $where;
		return mysqli_query($this->__conn, $sql);
	}

	// Get all records
	function get_list($sql) {

		$this->connect();

		$result = mysqli_query($this->__conn, $sql);

		if (!$result){
			die ('Query is incorrect!');
		}

		$return = array();

		// Loop data then pass to an array
		while ($row = mysqli_fetch_assoc($result)){
			$return[] = $row;
		}

		// Empty memory
		mysqli_free_result($result);

		if ($return && count($return) > 0)
			return $return[0];
		else
			return '';
	}

	// Get a record
	function get_row($sql) {

		$this->connect();

		$result = mysqli_query($this->__conn, $sql);

		if (!$result){
			die ('Query is incorrect');
		}

		$row = mysqli_fetch_assoc($result);

		mysqli_free_result($result);

		if ($row){
			return $row;
		}

		return false;
	}

	// Get a record
	function get_num_rows($sql) {

		$this->connect();

		$result = mysqli_query($this->__conn, $sql);

		if (!$result){
			die ('Query is incorrect');
		}

		$num_rows = mysqli_num_rows($result);

		return $num_rows;
	}

}

?>