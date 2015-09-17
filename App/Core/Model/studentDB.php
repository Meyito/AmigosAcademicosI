<?php

include_once "Core/Model/model.php";

class studentDB extends Model{

	public function addStudent($id,$password,$name,$semester,$email,$avatar){
		$this->connect();
		$query = $this->query("INSERT INTO Usuario('".$id."','".$name."','".$password."','".$email."',".$semester.",3,'".$avatar."','activo')");
		$this->terminate();
		return $query;
	}

	public function qualifyAsesoria(){
		
	}
}

?>