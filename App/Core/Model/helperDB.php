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
	public function updateCourse($id,$name,$description,$idAmigo,$fecha,$idMateria){
		$this->connect();
		$query = $this->query("UPDATE Curso SET nombre = '".$name."',descripcion = '".$description."',idAmigoAcademico = '".$idAmigo."',fecha = '".$fecha."',idMateria = '".$idMateria."' WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}
}

?>