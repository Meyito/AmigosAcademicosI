<?php

include_once "Core/Model/model.php";

class AdminDB extends Model{

	public function addMateria($id,$name,semester){
		$this->connect();
		$query = $this->query("INSERT INTO Materia VALUES ('".$id."','".$name."',".$semester.")");
		$this->terminate();
		return $query;
	}
	public function addAmigo($id,$password,$name,$semester,$email,$avatar,$array){
		$this->connect();
		$query = $this->query("INSERT INTO Usuario VALUES ('".$id."','".$name."','".$password."','".$email."',".$semester.",2,'".$avatar."')");
		if($query){
			$iter = 0;
			while($iter<count($array){
				$day = $array[$iter]/10;
				$hour = $array[$iter]%10;
				$query = $this->query("INSERT INTO Agenda VALUES ('".$id."',".$day.",".$hour.")");
				$iter++;
			}
			$this->terminate();
		}
		return $query;	
	}
}

?>