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

	public function getAsistenciasMateria(){
		$this->connect();
		$query = $this->query("SELECT COUNT(ea.idEstudiante), a.idMateria FROM EstudianteAsesoria ea, Asesoria a WHERE a.id=ea.idAsesoria GROUP BY a.idMateria");

		$this->terminate();
		
		$rta="";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$name = $this->getMateria($row[1]);
			$nc["p"] = $row[1];
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

	public function getMateria($id){
		$this->connect();
		$query = $this->query("SELECT nombre FROM Materia WHERE id='".$id."'");
		$this->terminate();

		$name="";
		while($row = mysqli_fetch_array($query)){
			$name = $row[0];
		}

		return $name;
	}

	public function getPromedioMateria(){
		$this->connect();
		$query = $this->query("SELECT AVG(promedioCalificacion) FROM Asesoria");
		$this->terminate();
		
		$array = array();
		while($row = mysqli_fetch_array($query)){
			$array['promedio']=round($row[0],2);
		}

		return json_encode($array);
	}

	public function getListaMaterias(){
		$this->connect();
		$query = $this->query("SELECT DISTINCT m.id, m.nombre FROM Materia m, Asesoria a WHERE m.id=a.idMateria");

		$this->terminate();
		
		$rta="[";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$nc["id"] = $row[0];
			$nc["nombre"] = $row[1];
			$aux=json_encode($nc);
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		$rta.="]";
		
		return $rta;
	}

	public function getListaTemas($id){
		$this->connect();
		$query = $this->query("SELECT DISTINCT m.id, m.nombre FROM Tema m, Asesoria a WHERE m.id=a.idTema AND m.idMateria='".$id."'");

		$this->terminate();
		
		$rta="[";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$nc["id"] = $row[0];
			$nc["nombre"] = $row[1];
			$aux=json_encode($nc);
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		$rta.="]";
		
		return $rta;
	}

	public function getFrecuenciaEstudiantes(){
		$this->connect();
		$query = $this->query("SELECT count(idAsesoria), idEstudiante FROM EstudianteAsesoria GROUP BY idEstudiante");

		$this->terminate();
		
		$rta="[";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$name=$this->getEstudiante($row[1]);
			$nc["nombre"] = $name;
			$nc["asesorias"] = $row[0];
			$aux=json_encode($nc);
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		$rta.="]";
		
		return $rta;
	}


	public function getFrecuenciaEstudiantesMateria($id){
		$this->connect();
		$query = $this->query("SELECT count(ea.idAsesoria), ea.idEstudiante FROM EstudianteAsesoria ea, Asesoria a WHERE a.id=ea.idAsesoria AND a.idMateria='".$id."'GROUP BY idEstudiante");

		$this->terminate();
		
		$rta="[";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$name=$this->getEstudiante($row[1]);
			$nc["nombre"] = $name;
			$nc["asesorias"] = $row[0];
			$aux=json_encode($nc);
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		$rta.="]";
		
		return $rta;
	}

	public function getFrecuenciaEstudiantesTema($id){
		$this->connect();
		$query = $this->query("SELECT count(ea.idAsesoria), ea.idEstudiante FROM EstudianteAsesoria ea, Asesoria a WHERE a.id=ea.idAsesoria AND a.idTema='".$id."'GROUP BY ea.idEstudiante");

		$this->terminate();
		
		$rta="[";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$name=$this->getEstudiante($row[1]);
			$nc["nombre"] = $name;
			$nc["asesorias"] = $row[0];
			$aux=json_encode($nc);
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		$rta.="]";
		
		return $rta;
	}

	public function getEstudiante($id){
		$this->connect();
		$query = $this->query("SELECT nombre FROM Usuario WHERE id='".$id."'");
		$this->terminate();

		$name="";
		while($row = mysqli_fetch_array($query)){
			$name = $row[0];
		}

		return $name;
	}

	public function getAmigos(){
		$this->connect();
		$query = $this->query("SELECT DISTINCT a.id, a.nombre FROM Usuario a, Asesoria c WHERE a.id=c.idAmigoAcademico");

		$this->terminate();
		
		$rta="[";
		$nc = array();

		while($row = mysqli_fetch_array($query)){
			$nc["id"] = $row[0];
			$nc["nombre"] = $row[1];
			$aux=json_encode($nc);
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		$rta.="]";
		return $rta;
	}

	public function getAsesoriasAmigo(){
		$this->connect();
		$query = $this->query("SELECT COUNT(ea.idEstudiante), a.idAmigoAcademico FROM EstudianteAsesoria ea, Asesoria a WHERE ea.idAsesoria=a.id  GROUP BY a.idAmigoAcademico");
		$this->terminate();
		
		$rta="";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$name = $this->getAmigo($row[1]);
			$nc["v"] = $name;
			$asis["v"] = $row[0];
			$aux='{"c":['.json_encode($nc).','.json_encode($asis).']}';
			$rta.=($aux.",");
		}

		$rta = trim($rta,",");
		
		return $rta;
	}

	public function getAsistentesPrograma(){
		$this->connect();
		$query = $this->query("SELECT COUNT( DISTINCT idEstudiante) FROM EstudianteAsesoria");
		$this->terminate();
		
		$rta="";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$nc["v"] = "Asistentes al programa";
			$asis["v"] = $row[0];
			$rta='{"c":['.json_encode($nc).','.json_encode($asis).']}';
		}
		return $rta;
	}

	public function getTotalEstudiantes(){
		$this->connect();
		$query = $this->query("SELECT cantidadEstudiantes FROM Periodo ORDER BY id DESC LIMIT 1");
		$this->terminate();
		
		$rta="";
		$nc = array();
		$asis = array();

		while($row = mysqli_fetch_array($query)){
			$nc["v"] = "Población total";
			$asis["v"] = $row[0];
			$rta='{"c":['.json_encode($nc).','.json_encode($asis).']}';
		}
		return $rta;
	}

	public function getAmigo($id){
		$this->connect();
		$query = $this->query("SELECT nombre FROM Usuario WHERE id='".$id."'");
		$this->terminate();

		$name="";
		while($row = mysqli_fetch_array($query)){
			$name = $row[0];
		}

		return $name;
	}


}
?>