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
			return $rta;
		}

		public function getPorcentajeEstudiantes(){
			$st=new StatsDB();

			$label1 = array('label' => 'Estudiantes', 'type' => 'string');
			$label2 = array('label' => 'Total', 'type' => 'number');
			
			$data1 = $st -> getAsistentesPrograma();
			$data2 = $st -> getTotalEstudiantes();

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
		 		$cad='{"c":[{"v":"'.key($data).'"},{"v":'.$asist.'}]},';
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
		 		$cad='{"c":[{"v":"'.key($data).'"},{"v":'.$asist.'}]},';
			    $rta .= $cad;
			    next($data);
			}

			$rta = trim($rta, ",");
			$rta .= ']}';

			return $rta;
		}

		public function getComparativa(){
			$st=new StatsDB();

			$periodos=$st->getLastPeriods();

			$data1 = $st->getComparativa($periodos[2][0]);
			$data2 = $st->getComparativa($periodos[1][0]);

			$porc1 = ($data1[1]*100)/$data1[2];
			$porc1 = round($porc1, 2);
			$porc2 = ($data2[1]*100)/$data2[2];
			$porc2 = round($porc2, 2);

			$rta='{"Periodo1": {
				"nombre": "'.$periodos[2][1].'",
				"calificacion": "'.$data1[0].'",
				"asistentes": "'.$data1[1].'",
				"estudiantes": "'.$data1[2].'",
				"porcentaje": "'.$porc1.'%"
			},
  			"Periodo2": {
  				"nombre": "'.$periodos[1][1].'",
    			"calificacion": "'.$data2[0].'",
    			"asistentes": "'.$data2[1].'",
    			"estudiantes": "'.$data2[2].'",
    			"porcentaje": "'.$porc2.'%"
  			}}';

			return $rta;
		}

		public function getComentariosAsesorias($idAmigo){
			$st=new StatsDB();

			$rta = '{';

			$data = $st->getComentariosAsesorias($idAmigo);

			for($i=1; $i<=count($data); $i++){
				$rta .= '"'.$i.'": {
							"calificacion": "'.$data[$i-1][0].'",
							"comentario": "'.$data[$i-1][1].'"
						},';
			}

			$rta = trim($rta, ",");
			$rta .= '}';

			return $rta;
		}

	}

?>