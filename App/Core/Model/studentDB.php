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
		$query = $this->query("UPDATE EstudianteAsesoria set calificacion = ".$qualification." WHERE idEstudiante = '".$idEstudiante."' AND idAsesoria = ".$idAsesoria."");
		$this->terminate();
		return $query;
	}

	public function qualifyCurso($idEstudiante,$idCurso,$qualification){
		$this->connect();
		$query = $this->query("UPDATE EstudianteCurso set calificacion = ".$qualification." WHERE idEstudiante = '".$idEstudiante."' AND idCurso = ".$idCurso."");
		$this->terminate();
		return $query;
	}

	public function getAsesoriasToQualify($idEstudiante){
		$this->connect();
		$query = $this->query("SELECT e.idAsesoria, u.nombre, a.fecha, t.nombre, m.nombre FROM Materia m, Tema t, Asesoria a, EstudianteAsesoria e, Usuario u 
			WHERE e.idEstudiante = '".$idEstudiante."' AND calificacion = IS NULL AND a.id=e.idAsesoria AND a.idAmigoAcademico=u.id AND a.idMateria=m.id AND a.idTema=t.id ");
		//"SELECT e.idAsesoria, u.nombre, a.fecha, m.nombre FROM Materia m, Tema t, Asesoria a, EstudianteAsesoria e, Usuario u WHERE e.idEstudiante = '1212' AND e.calificacion IS NULL AND a.id=e.idAsesoria AND a.idAmigoAcademico=u.id AND a.idMateria=m.id");
		$this->terminate();
		return $query;
	}
}

?>