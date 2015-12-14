<?php

class Model{

	private $connection;

	public function connect(){
		//cambiar parametros de conexión de acuerdo con los parametros locales de cada uno
		$this->connection = mysqli_connect("localhost","root","","AA") or die(mysqli_error($connection));
	}

	public function query($sql){
		//print_r($sql);
		return mysqli_query($this->connection,$sql);
	}

	public function terminate(){
		mysqli_close($this->connection);
	}

	public function lastId(){
		return mysqli_insert_id($this->connection);
	}

}

?>