<?php

include_once "App/Core/Model/model.php";

class UserDB extends Model{
	public function login($id,$password){
		$this->connect();
		$query = $this->query("SELECT * FROM Usuario WHERE id = '".$id."' AND contrasenia = '".$password."' ");
		$this->terminate();
		$cont = 0;
		$user = "";
		while($row = mysqli_fetch_array($query)){
			cont++;
			$user = $row;
		}
		if(cont==1){
			return $user;
		}
		else{
			return false;
		}

	}
}

?>