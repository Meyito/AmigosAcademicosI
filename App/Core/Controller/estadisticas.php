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

		 	$rta = '{ "cols": ['.json_encode($label1).','.json_encode($label2).','.json_encode($label3).'],';
		 	$rta .= '"rows": [';
		 	while ($asist = current($data)) {
		 		$cad='{"c":[{"v":"'.key($data).'"},{"v":'.$asist[0].'},{"v":';
			    if (count($asist)==2) {
			        $cad .= $asist[1].'}]},';
			    }else{
			    	$cad .= '0}]},';
			    }
			    $rta .= $cad;
			    next($data);
			}

			$rta = trim($rta,",");

			$rta .= ' ]		}';
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

		public function getCursosPrevio2(){
			$st=new StatsDB();

			$periodos=$st->getLastPeriods();

			$rta= '{ "cols": [
		        {"label":"'.$periodos[2][1].'","type":"string"},
		        {"label":"No. Estudiantes","type":"number"} ],
		         "rows": [';

			$data = $st->getCursosSem($periodos[2][0]);

			while ($asist = current($data)) {
		 		$cad='{"c":[{"v":"'.key($data).'"},{"v":'.$asist[0].'}]},';
			    $rta .= $cad;
			    next($data);
			}

			$rta = trim($rta, ",");
			$rta .= ']}';

			return $rta;
		}

		public function getCursosPrevio(){
			$st=new StatsDB();

			$periodos=$st->getLastPeriods();

			$rta= '{ "cols": [
		        {"label":"'.$periodos[1][1].'","type":"string"},
		        {"label":"No. Estudiantes","type":"number"} ],
		         "rows": [';

			$data = $st->getCursosSem($periodos[1][0]);

			while ($asist = current($data)) {
		 		$cad='{"c":[{"v":"'.key($data).'"},{"v":'.$asist[0].'}]},';
			    $rta .= $cad;
			    next($data);
			}

			$rta = trim($rta, ",");
			$rta .= ']}';

			return $rta;
		}

		public function getComparativa(){
			$st=new StatsDB();
			/*Nombre periodo1 y 2, es algo como la fecha o "Semestre*/
$string = '{
  	"Periodo1": {
  	"nombre": "Primer Semestre 2015",
    "calificacion": "4.3",
    "asistentes": "122",
    "estudiantes": "450",
    "porcentaje": "45"
  },
  "Periodo2": {
  	"nombre": "Segundo Semestre 2014",
    "calificacion": "4.3",
    "asistentes": "122",
    "estudiantes": "450",
    "porcentaje": "45"
  }
}';
		}

	}

?>