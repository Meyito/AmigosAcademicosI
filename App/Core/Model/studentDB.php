<?php

include_once "Core/Model/model.php";

class studentDB extends Model{

	public function addEstudiante($id,$password,$name,$semester,$email,$avatar){
		$this->connect();
		$query = $this->query("INSERT INTO Usuario VALUES('".$id."','".$name."','".$password."','".$email."',".$semester.",3,'".$avatar."','activo')");
		$this->terminate();
		return $query;
	}

	public function qualifyAsesoria($idEstudiante,$idAsesoria,$qualification){
		$this->connect();
		$query = $this->query("UPDATE EstudianteAsesoria set calificacion = ".$qualification." WHERE idEstudiante = '".$idEstudiante."' AND idAsesoria = '".$idAsesoria."'");
		$this->terminate();
		return $query;
	}

	public function getAsesoriasToQualify($idEstudiante){
		$this->connect();
		$query = $this->query("SELECT idAsesoria FROM EstudianteAsesoria WHERE idEstudiante = '".$idEstudiante."' AND calificacion = NULL");

	}
}

?>