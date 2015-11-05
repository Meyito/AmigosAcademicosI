<?php

include_once "model.php";

class AdminDB extends Model{

	public function addMateria($id,$name,$semester){
		$this->connect();
		$query = $this->query("INSERT INTO Materia VALUES ('".$id."','".$name."',".$semester.")");
		$this->terminate();
		return $query;
	}
	public function udpateMateria($id,$name,$semester){
		$this->connect();
		$query = $this->query("UPDATE Materia SET name = '".$name."',semester = '".$semester."' WHERE id = '".$id."' ");
		$this->terminate();
		return $query;
	}
	public function deleteMateria($id){
		$this->connect();
		$query = $this->query("DELETE FROM Materia WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}
	public function getMaterias(){
		$this->connect();
		$query = $this->query("SELECT * FROM Materia");
		$this->terminate();
		$array = array();

		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getTemas(){
		$this->connect();
		$query = $this->query("SELECT id,nombre FROM Tema");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getAmigos(){
		$this->connect();
		$query = $this->query("SELECT id, nombre FROM Usuario WHERE tipo = 2");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function addAmigo($id,$password,$name,$semester,$email,$avatar,$array){
		$this->connect();
		$query = $this->query("INSERT INTO Usuario VALUES ('".$id."','".$name."','".$password."','".$email."',".$semester.",2,'".$avatar."','activo')");
		if($query){
			$iter = 0;
			while($iter<count($array)){
				$day = floor($array[$iter]/10);
				$hour = $array[$iter]%10;
				$query = $this->query("INSERT INTO Agenda VALUES ('".$id."',".$day.",".$hour.")");
				$iter++;
			}
		}
		$this->terminate();
		return $query;	
	}

	public function addPeriodoAmigo($idAmigoAcademico,$idPeriodo){
		$this->connect();
		$query = $this->query("INSERT INTO AmigoPeriodo VALUES('".$idAmigoAcademico."',".$idPeriodo.")");
		$this->terminate();
		return $query;
	}

	public function deletePeriodoAmigo($idAmigoAcademico,$idPeriodo){
		$this->connect();
		$query = $this->query("DELETE FROM AmigoPeriodo WHERE idAmigoAcademico = '".$idAmigoAcademico."' AND idPeriodo = ".$idPeriodo."");
		$this->terminate();
		return $query;
	}

	public function addPeriodo($descripcion){
		$this->connect();
		$query = $this->query("SELECT FROM Periodo WHERE descripcion = '".$descripcion."'");
		$count = 0;
		while($row = mysqli_fetch_array($query)){
			$count++;
		}
		if($count<1){
			$query = $this->query("INSERT INTO Periodo(descripcion) VALUES('".$descripcion."')");
			$this->terminate();
			if($query){
				return true;
			}
		}
		$this->terminate();
		return false;
	}
	public function deletePeriodo($id){
		$this->connect();
		$query = $this->query("DELETE FROM Periodo WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}
	public function getPeriodos(){
		$this->connect();
		$array = array();
		$query = $this->query("SELECT * FROM Periodo");
		$this->terminate();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function updateAmigo($id, $password, $name, $semester, $email, $horario){
		$this->changeAgenda($id, $horario);
		$this->connect();		
		$query = $this->query("UPDATE Usuario SET nombre = '".$name."',contrasenia = '".$password."',correoElectronico = '".$email."',semestre = '".$semester."' WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}

	public function deleteUsuario($id){
		$this->connect();
		$query = $this->query("DELETE FROM Usuario WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}

	public function getAmigo($id){
		$this->connect();
		$query = $this->query("SELECT * FROM Usuario WHERE id = '".$id."' AND tipo = 2");
		$iter = 0;
		$array = array();
		while($row = mysqli_fetch_array($query)){
			$iter++;
			array_push($array,$row);
		}
		if($iter>0){
			$schedule = array();
			$query = $this->query("SELECT dia,hora FROM Agenda WHERE idAmigoAcademico='".$id."' ");
			
			while($row = mysqli_fetch_array($query)){
				array_push($schedule,$row);
			}
			array_push($array,$schedule);
			$this->terminate();
			return $array;
		}
		else{
			$this->terminate();
			return false;
		}
	}

	public function getTema($materia){
		$this->connect();
		$query = $this->query("SELECT id,nombre FROM Tema WHERE idMateria='".$materia."'");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

	public function getAgenda(){
		$this->connect();
		$query = $this->query("SELECT id,nombre FROM Usuario WHERE tipo = 2");
		$iter = 0;
		$array = array();
		while($row = mysqli_fetch_array($query)){
			$iter++;
			array_push($array,$row);
		}
		if($iter>0){
			$index = 0;
			while($iter>0){
				$schedule = array();
				$id = $array[$index]['id'];
				$query = $this->query("SELECT dia,hora FROM Agenda WHERE idAmigoAcademico='".$id."'");
				while($row = mysqli_fetch_array($query)){
					array_push($schedule,$row);
				}
				array_push($array[$index],$schedule);
				$iter--;
				$index++;
			}
			$this->terminate();
			return $array;
		}
		else{
			$this->terminate();
			return false;
		}
	}
	public function changeAgenda($idAmigo,$array){
		$this->connect();
		$query = $this->query("DELETE FROM Agenda WHERE idAmigoAcademico = '".$idAmigo."'");
		if($query){
			$iter = 0;
			while($iter<count($array)){
				$day = floor($array[$iter]/10);
				$hour = $array[$iter]%10;
				$query = $this->query("INSERT INTO Agenda VALUES ('".$idAmigo."',".$day.",".$hour.")");
				$iter++;
			}
		}
		$this->terminate();
		return $query;
	}

	public function addCurso($idTema,$description,$idAmigo,$fecha,$idMateria){
		$this->connect();
		$query = $this->query("INSERT INTO Curso(idTema,descripcion,idAmigoAcademico,fecha,estado,idMateria) VALUES(".$idTema.",'".$description."','".$idAmigo."','".$fecha."','activo','".$idMateria."')");
		$this->terminate();
		return $query;
	}

	public function deleteCurso($id){
		$this->connect();
		$query = $this->query("DELETE FROM Curso WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}

	public function updateCurso($id,$description,$idAmigo,$fecha,$idMateria,$idTema){
		$this->connect();
		$query = $this->query("UPDATE Curso SET descripcion = '".$description."', idAmigoAcademico = '".$idAmigo."',fecha = '".$fecha."',idMateria = '".$idMateria."',idTema = ".$idTema." WHERE id = '".$id."'");
		$this->terminate();
		return $query;
	}

	public function getCurso($id){
		$this->connect();
		$query = $this->query("SELECT t.nombre FROM Tema t, Curso c WHERE c.id = '".$id."' AND t.id=c.idTema");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}
	
}

?>