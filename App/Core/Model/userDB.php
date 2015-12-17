<?php

include_once "Core/Model/model.php";

class UserDB extends Model{
	
	public function login($id,$password){
		$this->connect();
		$query = $this->query("SELECT * FROM Usuario WHERE id = '".$id."' AND contrasenia = '".$password."' ");
		$this->terminate();
		$cont = 0;
		$user = "";
		while($row = mysqli_fetch_array($query)){
			$cont++;
			$user = $row;
		}
		
		if($cont==1){
			return $user;
		}
		else{
			return false;
		}
	}
	public function isAvailable($id){
		$this->connect();
		$query = $this->query("SELECT * FROM Usuario WHERE id= '".$id."'");
		$this->terminate();
		$iter = 0;
		while($row = mysqli_fetch_array($query)){
			$iter++;
		}
		if($iter<0){
			return true;
		}
		else{
			return false;
		}
		
	}

	public function updateUsuario($id,$password,$name,$semester,$email,$avatar){
		$this->connect();
		$query = $this->query("UPDATE Usuario SET id = '".$id."',nombre = '".$name."',contrasenia = '".$password."',correoElectronico = '".$email."',semestre = ".$semester.",avatar = '".$avatar."' WHERE id='".$id."' ");
		$this->terminate();
		return $query;
	}
	
	public function getAmigos(){
		$this->connect();
		$query = $this->query("SELECT id,nombre,estado FROM Usuario WHERE tipo = 2 AND estado='activo'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getCursos(){
		$this->connect();
		$query = $this->query("SELECT c.id, t.nombre,c.fecha,m.nombre,u.nombre FROM Curso c,Tema t,Materia m,Usuario u 
								WHERE t.id = c.idTema AND m.id = c.idMateria AND u.id = c.idAmigoAcademico AND c.fecha >= CURDATE()								ORDER BY c.fecha");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getTemasActivos(){
		$this->connect();
		$query = $this->query("SELECT t.id,t.nombre,m.nombre  FROM Tema t,Materia m WHERE t.estado = 1 AND t.idMateria = m.id");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getTemasAll(){
		$this->connect();
		$query = $this->query("SELECT t.id,t.nombre,m.nombre, t.estado FROM Tema t,Materia m WHERE t.idMateria = m.id");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function agregarTemas($tema, $idMateria){
		$this->connect();
		$query=$this->query("INSERT INTO Tema(nombre,idMateria,estado) VALUES('".$tema."','".$idMateria."',1)");
		$this->terminate();
		return $query;
	}

	public function desactivarTema($idTema){
		$this->connect();
		$query=$this->query("UPDATE Tema SET estado = 2 WHERE id = '".$idTema."'");
		$this->terminate();
		return $query;
	}

	public function activarTema($idTema){
		$this->connect();
		$query=$this->query("UPDATE Tema SET estado = 1 WHERE id = '".$idTema."'");
		$this->terminate();
		return $query;
	}

	public function eliminarTema($idTema){
		$this->connect();
		$query=$this->query("DELETE FROM Tema WHERE id = '".$idTema."'");
		$this->terminate();
		return $query;
	}

	public function getAmigosHistoricos(){
		$this->connect();
		$query = $this->query("SELECT id, nombre FROM Usuario WHERE tipo = 2 AND estado='inactivo'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function activarAAH($cod){
		$this->connect();
		$query=$this->query("UPDATE Usuario SET estado = 'activo' WHERE id = '".$cod."'");
		$this->terminate();
		return $query;
	}

	public function getAmigoHistorico($cod){
		$this->connect();
		$query = $this->query("SELECT nombre, correoElectronico FROM Usuario WHERE tipo = 2 AND id='".$cod."'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getPeriodos($cod){
		$this->connect();
		$query = $this->query("SELECT descripcion FROM Periodo, AmigoPeriodo WHERE id = idPeriodo AND idAmigoAcademico='".$cod."'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

}

?>