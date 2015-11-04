<?php

include_once  "Core/Model/model.php";

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
	public function addAsistenciaAsesoria($idEstudiante, $idAsesoria, $description){
		$this->connect();
		$query = $this->query("INSERT INTO EstudianteAsesoria(idEstudiante,idAsesoria,observacion) VALUES('".$idEstudiante."','".$idAsesoria."','".$description."')");
		$this->terminate();
		return $query;
	}
	public function deleteAsistenciaAsesoria($idEstudiante,$idAsesoria){
		$this->connect();
		$query = $this->query("DELETE FROM EstudianteAsesoria WHERE idEstudiante = '".$idEstudiante."' AND idAsesoria'".$idAsesoria."'");
		$this->terminate();
		return $query;

	}
	public function updateCourse($id,$name,$description,$idAmigo,$fecha,$idMateria){
		$this->connect();
		$query = $this->query("UPDATE Curso SET nombre = '".$name."',descripcion = '".$description."',idAmigoAcademico = '".$idAmigo."',fecha = '".$fecha."',idMateria = '".$idMateria."' WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}
	public function addAsesoria($idAmigo,$idMateria){
		$this->connect();
		$query = $this->query("INSERT INTO Asesoria(idAmigoAcademico,fecha,idMateria) VALUES('".$idAmigo."',CURDATE(),'".$idMateria."')");
		$id= $this->lastId();
		$this->terminate();
		return $id;
	}
	public function udpateAsesoria($id,$idAmigo,$idMateria,$date){
		$this->connect();
		$this->query("UPDATE Asesoria SET idAmigoAcademico = '".$idAmigo."',fecha = '".$date."',idMateria = '".$materia."' WHERE id='".$id."'");
		$this->terminate();
		return $query;
	}
	public function getAsesoria($id){
		$this->connect();
		$this->query("SELECT * FROM Asesorias WHERE id = '".$id."'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	public function getAsesorias(){
		$this->connect();
		$this->query("SELECT * FROM Asesorias");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
}

?>