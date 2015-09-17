<?php

include_once = "Core/Model/model.php";

class helperDB extends Model{

	public function addAsistenciaCurso($idEstudiante,$idCurso){
		$this->connect();
		$query->query("INSERT INTO EstudianteCurso VALUES('".$idEstudiante."',".$idCurso.")");
		$this->terminate();
		return $query;
	}
	public function deleteAsistenciaCurso($idEstudiante,$idCurso){
		$this->connect();
		$query->query("DELETE FROM EstudianteCurso WHERE idEstudiante = '".$idEstudiante."' AND idCurso = ".$idCurso."");
		$this->terminate();
		return $query;
	}
}

?>