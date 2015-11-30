<?php

include_once "model.php";

class StatsDB extends Model{

	public function getPromedioCursos(){
		$this->connect();
		$query = $this->query("SELECT AVG(promedioCalificacion) FROM Curso");
		$this->terminate();
		
		$array = array();
		while($row = mysqli_fetch_array($query)){
			$array['promedio']=round($row[0],2);
		}

		return json_encode($array);
	}

	public function getPromedioCursoAmigo($id){
		$this->connect();
		$query = $this->query("SELECT AVG(promedioCalificacion) FROM Curso WHERE idAmigoAcademico = '".$id."'");
		$this->terminate();
		
		$array = array();
		while($row = mysqli_fetch_array($query)){
			$array['promedio']=round($row[0],2);
		}

		return json_encode($array);
	}

	public function getAsistenciaCursos(){
		$this->connect();
		$query = $this->query("SELECT COUNT(idEstudiante), idCurso FROM EstudianteCurso GROUP BY idCurso");
		$this->terminate();
		
		$rta="";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$name = $this->getCurso($row[1]);
			$nc["v"] = $name;
			$asis["v"] = $row[0];
			$aux='{"c":['.json_encode($nc).','.json_encode($asis).']}';
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		
		return $rta;
	}

	public function getAsistenciaCursoAmigo($id){
		$this->connect();
		$query = $this->query("SELECT COUNT(ce.idEstudiante), ce.idCurso FROM EstudianteCurso ce, Curso c WHERE c.id=ce.idCurso AND c.idAmigoAcademico='".$id."' GROUP BY ce.idCurso");
		$this->terminate();
		
		$rta="";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$name = $this->getCurso($row[1]);
			$nc["v"] = $name;
			$asis["v"] = $row[0];
			$aux='{"c":['.json_encode($nc).','.json_encode($asis).']}';
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		
		return $rta;

	}

	public function getCurso($id){
		$this->connect();
		$query = $this->query("SELECT t.nombre FROM Tema t, Curso c WHERE t.id=c.idTema AND c.id='".$id."'");
		$this->terminate();

		$name="";
		while($row = mysqli_fetch_array($query)){
			$name = $row[0];
		}

		return $name;
	}

}
?>