<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/studentDB.php";
	include_once "Core/Model/userDB.php";

	class Student extends Controller{

		public function index(){
			$index=$this->base("Core/View/assets/menu_estudiante.html");
			$content=$this->getTemplate("Core/View/contenedores/inicio_estudiante.html");
			$content=$this->getHorario($content);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);

			$asesorias=$this->getNotificaciones();
			$index=$this->renderView($index, "{{CICLO:NOTIFICACION_ASESORIA}}", $asesorias);
			$this->showView($index);
		}

		public function getNotificaciones(){
			$base=$this->getTemplate("Core/View/assets/notificacion_asesoria.html");
			$studentModel=new studentDB();

			$data=$studentModel->getAsesoriasToQualify($_SESSION["codigo"]);
			$aux="";
			$tm="";

			for($i=0; $i<count($data); $i++){
				$tm=$base;
				$tm=$this->renderView($tm, "{{BASICO:IDENTIFICADOR}}", $base[$i][0]);
				$tm=$this->renderView($tm, "{{BASICO:AMIGO}}", $base[$i][1]);
				$tm=$this->renderView($tm, "{{BASICO:FECHA}}", $base[$i][2]);
				$tm=$this->renderView($tm, "{{BASICO:TEMA}}", $base[$i][3]);
				$tm=$this->renderView($tm, "{{BASICO:MATERIA}}", $base[$i][4]);

				$aux .= $tm;
			}

			return $aux;
		}

		public function topics(){
			$index=$this->base("Core/View/assets/menu_estudiante.html");
			$content=$this->getTemplate("Core/View/contenedores/estudiante_ver_temas.html");
			$temas=$this->getTemas();
			$content=$this->renderView($content, "{{CICLO:TEMAS}}", $temas);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($index);
		}

		public function courses(){
			$index=$this->base("Core/View/assets/menu_estudiante.html");
			$content=$this->getTemplate("Core/View/contenedores/estudiante_vista_cursos.html");
			$courses=$this->getCursos();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}", $courses);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($index);
		}
		
		public function getCursos(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos_estudiante.html");
			$userModel=new UserDB();
			$data=$userModel->getCursos();

			$aux="";
			$list="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:NOMBRE_CURSO}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:FECHA_CURSO}}", $data[$i]["fecha"]);
				$aux=$this->renderView($aux, "{{BASICO:NOMBRE_AMIGO}}", $data[$i][4]);
				//$aux=$this->renderView($aux, "{{id}}", $data[$i][0]);
				$list=$list.$aux;
			}
			return $list;
		}

		public function changeAvatar(){
			$view=$this->base("Core/View/assets/menu_estudiante.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function help(){
			$view=$this->base("Core/View/assets/menu_estudiante.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}


		public function rateAdvice(){

		}

		public function rateCourse(){

		}
	}
?>