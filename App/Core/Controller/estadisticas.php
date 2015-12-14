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
			//print_r($data);
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

		public function getHistoricaMateria(){
			$st=new StatsDB();

			$periodos=$st->getLastPeriods();

			$label1 = array('label' => 'Materia', 'type' => 'string');
			$label2 = array('label' => $periodos[2][1], 'type' => 'number');
			$label3 = array('label' => $periodos[1][1], 'type' => 'number');
			
		 	$data = $st -> getAsistentesMateria($periodos[2][0], $periodos[1][0]);

		 	print_r($data);

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).','.json_encode($label3).'],';
			$rta .= '"rows": [
		        {"c":[{"v":"Programación Orientada a Objetos"},{"v":34},{"v":34}]},
		        {"c":[{"v":"Estructuras de Datos"},{"v":11},{"v":34}]},
		        {"c":[{"v":"Fundamentos de Programación"},{"v":33},{"v":34}]},
		        {"c":[{"v":"Calculo Diferencial"},{"v":59},{"v":34}]},
		        {"c":[{"v":"Física Mecánica"},{"v":81},{"v":34}]},
		        {"c":[{"v":"Ondas y Particulas"},{"v":13},{"v":34}]}
		      ]
		}';
			return $rta;
		}

		public function getEstadisticaMateriaTema($id){
			$st=new StatsDB();

			$label1 = array('label' => 'Tema', 'type' => 'string');
			$label2 = array('label' => 'No. Estudiantes', 'type' => 'number');
			
			$data = $st -> getEstadisticaMateriaTema($id);

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).'],"rows": [ '.$data.']}';

			return $rta;

		}

		public function getEstadisticaAmigo($id){
			$st=new StatsDB();

			$label1 = array('label' => 'Materia', 'type' => 'string');
			$label2 = array('label' => 'No. Asesorias', 'type' => 'number');
			
			$data = $st -> getEstadisticaAmigo($id);

			$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).'],"rows": [ '.$data.']}';
			return $rta;
		}

	}

?>