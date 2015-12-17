<?php

	/**
 	* .............................................
 	* UNIVERSIDAD  FRANCISCO  DE  PAULA  SANTANDER
 	*    PROGRAMA  DE  INGENIERIA   DE   SISTEMAS
 	*         AMIGOS ACADEMICOS INTERACTIVOS
 	*             SAN JOSE DE CUCUTA-2015
	* ............................................
 	*/

 	include_once "Core/Model/model.php";

 	/**
	* @author Gerson Yesid Lazaro Carrillo 1150972
	* @author Angie Melissa Delgado León 1150990
	* @author Juan Daniel Vega Santos 1150958
	*/

class studentDB extends Model{

	public function addEstudiante($id,$password,$name,$semester,$email,$avatar){
		$this->connect();
		$query = $this->query("INSERT INTO Usuario VALUES('".$id."','".$name."','".$password."','".$email."',".$semester.",3,'".$avatar."','activo')");
		$this->terminate();
		return $query;
	}

	public function qualifyAsesoria($idEstudiante,$idAsesoria,$qualification, $observation){
		$this->connect();
		$query = $this->query("UPDATE EstudianteAsesoria set calificacion = ".$qualification.", observacionEstudiante = '".$observation."' WHERE idEstudiante = '".$idEstudiante."' AND idAsesoria = ".$idAsesoria."");
		$this->terminate();
		return $query;
	}

	public function calificacionPromedioA($id){
		$this->connect();
		$query = $this->query("SELECT AVG(calificacion) FROM EstudianteAsesoria WHERE idAsesoria='".$id."'");
		$avg; 
		while($row = mysqli_fetch_array($query)){
			$avg=$row[0];
		}
		$query2 = $this->query("UPDATE Asesoria SET promedioCalificacion = ".$avg." WHERE id = '".$id."'");
		return $query2;
	}

	public function qualifyCurso($idEstudiante,$idCurso,$qualification){
		$this->connect();
		$query = $this->query("UPDATE EstudianteCurso set calificacion = ".$qualification." WHERE idEstudiante = '".$idEstudiante."' AND idCurso = ".$idCurso."");
		$this->terminate();
		return $query;
	}

	public function calificacionPromedioC($id){
		$this->connect();
		$query = $this->query("SELECT AVG(calificacion) FROM EstudianteCurso WHERE idCurso='".$id."'");
		$this->terminate();
		$avg; 
		while($row = mysqli_fetch_array($query)){
			$avg=$row[0];
		}
		$query2 = $this->query("UPDATE Curso SET promedioCalificacion = ".$avg." WHERE id = '".$id."'");
		return $query2;
	}

	public function getAsesoriasToQualify($idEstudiante){
		$this->connect();
		$query = $this->query("SELECT e.idAsesoria, u.nombre, a.fecha, t.nombre, m.nombre FROM Materia m, Tema t, Asesoria a, EstudianteAsesoria e, Usuario u 
			WHERE e.idEstudiante = '".$idEstudiante."' AND calificacion IS NULL AND a.id=e.idAsesoria AND a.idAmigoAcademico=u.id AND a.idMateria=m.id AND a.idTema=t.id ");
		$this->terminate();
		
		$array = array();

		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getCursosToQualify($idEstudiante){
		$this->connect();
		$query = $this->query("SELECT e.idCurso, u.nombre, c.fecha, t.nombre, m.nombre FROM Materia m, Tema t, Curso c, EstudianteCurso e, Usuario u 
			WHERE e.idEstudiante = '".$idEstudiante."' AND calificacion IS NULL AND c.id=e.idCurso AND c.idAmigoAcademico=u.id AND c.idMateria=m.id AND c.idTema=t.id ");
		$this->terminate();
		
		$array = array();

		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
}

?>