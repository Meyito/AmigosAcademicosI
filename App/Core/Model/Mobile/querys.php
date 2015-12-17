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
	public function registrarCalificacionAsesoria($idAsesoria,$puntaje,$comentario,$estudiante){
		$this->connect();
		$query = $this->query("UPDATE EstudianteAsesoria SET calificacion = ".$puntaje.", observacionEstudiante = '".$comentario."' WHERE idAsesoria = ".$idAsesoria." AND idEstudiante = '".$estudiante."' ");
		$this->terminate();
		return $query;
	}
	public function registrarCalificacionCurso($idCurso,$puntaje,$estudiante){
		$this->connect();
		$query = $this->query("UPDATE EstudianteCurso SET calificacion = ".$puntaje." WHERE idCurso = ".$idCurso." AND idEstudiante = '".$estudiante."' ");
		$this->terminate();
		return $query;
	}
	public function registrarAsesoria($materia,$tema,$codigoAmigo,$codigoEstudiante,$comentario){
		$this->connect();
		$query = $this->query("INSERT INTO Asesoria(idAmigoAcademico,fecha,idMateria,idTema) VALUES('".$codigoAmigo."',CURDATE(),'".$materia."',".$tema.")");
		if($query){
			$count = $this->query("SELECT MAX(id) FROM Asesoria");
			$idAsesoria;
			while($row = mysqli_fetch_array($count)){
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
		$this->terminate();
		return $query;
	}
	public function registrarTema($nombre,$materia){
		$this->connect();
		$query = $this->query("INSERT INTO Tema(nombre,idMateria,estado) VALUES('".$nombre."','".$materia."',2)");
		$this->terminate();
		return $query;
	}
	public function editarCurso($id,$idMateria,$idTema,$idAmigo,$fecha,$hora,$descripcion){
		$this->connect();
		$query = $this->query("UPDATE Curso SET idTema = ".$idTema.",descripcion = '".$descripcion."',idAmigoAcademico = '".$idAmigo."',fecha = '".$fecha."',hora = '".$hora."',idMateria = '".$idMateria."' WHERE id = ".$id." ");
		$this->terminate();
		return $query;
	}
	public function eliminarCurso($id){
		$this->connect();
		$query = $this->query("DELETE FROM Curso WHERE id = ".$id." ");
		$this->terminate();
		return $query;
	}
	public function crearCurso($idTema,$descripcion,$idAmigo,$fecha,$hora,$idMateria){
		$this->connect();
		$query = $this->query("INSERT INTO Curso(idTema,descripcion,idAmigoAcademico,fecha,hora,estado,idMateria) VALUES(".$idTema.",'".$descripcion."','".$idAmigo."','".$fecha."','".$hora."','activo','".$idMateria."')");
		$this->terminate();
		return $query;
	}
	public function actualizarAmigo($codigo,$nombre,$correo,$semestre){
		$this->connect();
		$query = $this->query("UPDATE Usuario SET nombre = '".$nombre."',correoElectronico = '".$correo."',semestre = ".$semestre." WHERE id = '".$codigo."' AND tipo = 2 ");
		$this->terminate();
		return $query;
	}
	public function nuevoAmigo($id,$nombre,$correo,$semestre,$contrasenia,$contrasenia2){
		$this->connect();
		if($contrasenia === $contrasenia2){
			$query = $this->query("INSERT INTO Usuario VALUES('".$id."','".$nombre."','".$contrasenia."','".$correo."',".$semestre.",2,'Static/img/avatars/h2.png','activo')");
			$this->terminate();
			return $query;
		}
		else{
			return false;
		}
	}
	public function horario(){
		$this->connect();
		$query = $this->query("SELECT a.dia,a.hora,u.nombre FROM Agenda a,Usuario u WHERE a.idAmigoAcademico = u.id");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	public function temasSemana(){
		$this->connect();
		$query = $this->query("SELECT t.nombre,m.nombre FROM Tema t,Materia m WHERE t.idMateria = m.id AND t.estado = 1");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	public function proximosCursos(){
		$this->connect();
		$query = $this->query("SELECT c.id,t.nombre,c.descripcion,u.nombre,c.fecha,TIME_FORMAT(c.hora,'%h:%i'),m.nombre FROM Curso c,Usuario u,Materia m,Tema t 
							WHERE c.idAmigoAcademico = u.id AND c.idTema = t.id AND c.idMateria = m.id");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;

	}
	public function calificacionAsesoria($codigoEstudiante){
		$this->connect();
		$query = $this->query("SELECT a.id,m.nombre,t.nombre,u.nombre,a.fecha FROM Asesoria a,Usuario u,Tema t,Materia m,EstudianteAsesoria e
							WHERE a.idTema = t.id AND a.idMateria = m.id AND a.idAmigoAcademico = u.id AND e.idAsesoria = a.id AND e.idEstudiante = '".$codigoEstudiante."' AND e.calificacion IS NULL");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	public function calificacionCurso($codigoEstudiante){
		$this->connect();
		$query = $this->query("SELECT c.id,m.nombre,t.nombre,u.nombre,c.fecha FROM Curso c,Usuario u,Tema t,Materia m,EstudianteCurso e
							WHERE c.idTema = t.id AND c.idMateria = m.id AND c.idAmigoAcademico = u.id AND e.idCurso = c.id AND e.idEstudiante = '".$codigoEstudiante."' AND e.calificacion IS NULL");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	public function cargarMaterias(){
		$this->connect();
		$query = $this->query("SELECT id,nombre FROM Materia");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	public function cargarTemas($materia){
		$this->connect();
		$query = $this->query("SELECT id,nombre FROM Tema WHERE idMateria = '".$materia."'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	public function listarCursos($amigo){
		$this->connect();
		$query = $this->query("SELECT c.id,t.nombre,c.fecha FROM Curso c,Tema t WHERE c.idAmigoAcademico = '".$amigo."' AND c.idTema = t.id");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;

	}
	public function cargarListaAmigos(){
		$this->connect();
		$query = $this->query("SELECT id,nombre FROM Usuario WHERE tipo = 2 AND estado = 'activo'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;

	}
	public function obtenerDatosAA($codigo){
		$this->connect();
		$query = $this->query("SELECT id,nombre,correoElectronico,semestre FROM Usuario WHERE id = '".$codigo."' AND tipo = 2 AND estado = 'activo'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
		
	}
}

?>