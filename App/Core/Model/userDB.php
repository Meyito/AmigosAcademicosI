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
	public function updateUser($id,$password,$name,$semester,$email,$avatar){
		$this->connect();
		$query = $this->query("UPDATE Usuario SET id = '".$id."',nombre = '".$name."',contrasenia = '".$password."',correoElectronico = '".$email."',semestre = ".$semester.",avatar = '".$avatar."' WHERE id='".$id."' ");
		$this->terminate();
		return $query;
	}
	
	public function getAmigos(){
		$this->connect();
		$query = $this->query("SELECT id,nombre,estado FROM Usuario WHERE tipo = 2");
		$this->terminate();
		$array = array();
		while($row = mysqli_fetch_array($query)){
			array_push($array,$row);
		}
		return $array;
	}

}

?>