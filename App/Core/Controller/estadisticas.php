<?php

	require_once "controller.php";
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

			print_r($rta);
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



	}

?>