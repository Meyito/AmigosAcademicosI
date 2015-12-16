<?php

include_once "Core/Model/model.php";

class MobileQuery extends Model{

	public function login($id,$password){
		$this->connect();
		$query = $this->query("SELECT id,nombre,tipo FROM Usuario WHERE id='".$id."' AND contrasenia = '".$password."'");
		$this->terminate();
		$user = "";
		$cont = 0;
		while($row = mysqli_fetch_array($query)){
			$cont++;
			$user = $row;
		}
		if($cont>0){
			return $user;
		}
		return false;
	}

	public function registrar($id,$nombre,$correo,$semestre,$contrasenia,$contrasenia2){
		$this->connect();
		if($contrasenia === $contrasenia2){
			$query = $this->query("INSERT INTO Usuario VALUES('".$id."','".$nombre."','".$contrasenia."','".$correo."',".$semestre.",3,'Static/img/avatars/h13.png','activo')");
			$this->terminate();
			return $query;
		}
		else{
			return false;
		}
	}
	public function registrarCalificacion($idAsesoria,$puntaje,$comentario,$estudiante){
		$this->connect();
		$query = $this->query("UPDATE EstudianteAsesoria SET calificacion = ".$puntaje.", observacionEstudiante = '".$comentario."' WHERE idAsesoria = ".$idAsesoria." AND idEstudiante = '".$estudiante."' ");
		$this->terminate();
		return $query;
	}
	//REVISAR ESTE METODO
	public function registrarAsesoria($materia,$tema,$codigoAmigo,$codigoEstudiante,$comentario){
		$this->connect();
		$query = $this->query("INSERT INTO Asesoria(idAmigoAcademico,fecha,idMateria,idTema) VALUES('".$codigoAmigo."',CURDATE(),'".$materia."',".$tema.")");
		if($query){
			$query = $this->query("SELECT COUNT(*) FROM Asesoria");
			$idAsesoria = "";
			while($row = mysqli_fetch_array($query)){
				$idAsesoria = $row;
			}
			$query = $this->query("INSERT INTO EstudianteAsesoria(idEstudiante,idAsesoria,observacionAmigo) VALUES('".$codigoEstudiante."',".$idAsesoria[0].",'".$comentario."')");
		}
		$this->terminate();
		return $query;
	}
	public function registrarAsistenciaCurso($idCurso,$codigoEstudiante){
		$this->connect();
		$query = $this->query("INSERT INTO EstudianteCurso(idEstudiante,idCurso) VALUES('".$codigoEstudiante."',".$idCurso.")");
		$terminate();
		return $query;
	}
	public function registrarTema($nombre,$materia){
		$this->connect();
		$query = $this->query("INSERT INTO Tema(nombre,idMateria,estado) VALUES('".$nombre."','".$materia."',2)");
		$this->terminate();
		return $query;
	}
	public function editarCurso(){

	}
}

?>