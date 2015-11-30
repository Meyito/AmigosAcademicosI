<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/statsDB.php";

	include_once "Core/Model/adminDB.php";
	include_once "Core/Model/userDB.php";

	class Estadisticas extends Controller{

		public function getPromedioCursos(){
			$st=new StatsDB();

			$data=$st->getPromedioCursos();

			return $data;
		}

		public function getPromedioCursoAmigo($id){
			$st=new StatsDB();

			$data=$st->getPromedioCursoAmigo($id);

			return $data;
		}

		public function getAsistenciaCursos(){
			$st=new StatsDB();

			$label1 = array('label' => 'Curso', 'type' => 'string');
			$label2 = array('label' => 'No. Estudiantes', 'type' => 'number');
			
			$data = $st -> getAsistenciaCursos();

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).'],"rows": [ '.$data.']}';
			return $rta;
		}

		public function getAsistenciaCursoAmigo($id){
			$st=new StatsDB();

			$label1 = array('label' => 'Curso', 'type' => 'string');
			$label2 = array('label' => 'No. Estudiantes', 'type' => 'number');
			
			$data = $st -> getAsistenciaCursoAmigo($id);

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).'],"rows": [ '.$data.']}';

			print_r($rta);
			return $rta;
		}

		public function getAsistenciasMateria(){
			$st=new StatsDB();

			$label1 = array('label' => 'Curso', 'type' => 'string');
			$label2 = array('label' => 'No. Estudiantes', 'type' => 'number');
			
			$data = $st -> getAsistenciasMateria();

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).'],"rows": [ '.$data.']}';

			return $rta;
		}

		public function getPromedioMateria(){
			$st=new StatsDB();

			$data=$st->getPromedioMateria();

			return $data;
		}

		public function getListaMaterias(){
			$st=new StatsDB();

			$data=$st->getListaMaterias();

			return $data;
		}

		public function getListaTemas($id){
			$st=new StatsDB();

			$data=$st->getListaTemas($id);

			return $data;
		}

		public function getFrecuenciaEstudiantes(){
			$st=new StatsDB();

			$data=$st->getFrecuenciaEstudiantes();

			return $data;
		}

		public function getFrecuenciaEstudiantesMateria($id){
			$st=new StatsDB();

			$data=$st->getFrecuenciaEstudiantesMateria($id);

			return $data;
		}

		public function getFrecuenciaEstudiantesTema($id){
			$st=new StatsDB();

			$data=$st->getFrecuenciaEstudiantesTema($id);

			return $data;
		}

		public function getAmigos(){
			$st=new StatsDB();

			$data=$st->getAmigos();

			return $data;
		}

		public function getAsesoriasAmigo(){
			$st=new StatsDB();

			$label1 = array('label' => 'Amigo Académico', 'type' => 'string');
			$label2 = array('label' => 'No. Asesorias', 'type' => 'number');
			
			$data = $st -> getAsesoriasAmigo();

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).'],"rows": [ '.$data.']}';

			return $rta;
		}

		public function getPorcentajeEstudiantes(){
			$st=new StatsDB();

			$label1 = array('label' => 'Estudiantes', 'type' => 'string');
			$label2 = array('label' => 'Total', 'type' => 'number');
			
			$data1 = $st -> getAsistentesPrograma();
			$data2 = $st -> getAsesoriasAmigo();

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).'],"rows": [ '.$data1.', '.$data2.']}';

			return $rta;
		}




	}

?>