<?php

	require_once "Core/Controller/controller.php";
	include_once "Core/Model/studentDB.php";
	include_once "Core/Model/userDB.php";

	class Student extends Controller{

		public function index(){
			$index=$this->base("Core/View/assets/menu_estudiante.html");
			$content=$this->getTemplate("Core/View/contenedores/inicio_estudiante.html");
			$content=$this->getHorario($content);
			$content=$this->getNotificaciones($content);			
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($index);
		}

		public function getNotificaciones($content){
			$base=$this->getTemplate("Core/View/assets/notificacion_asesoria.html");
			$studentModel=new studentDB();

			$data=$studentModel->getAsesoriasToQualify($_SESSION["codigo"]);

			if(count($data)==0){
				$content=$this->renderView($content, "{{CICLO:NOTIFICACION_ASESORIA}}", "");
				$content=$this->renderView($content, "{{COMPUESTO:MODAL_ASESORIA}}", "");
				return $content;
			}

			$aux="";
			$tm="";

			for($i=0; $i<count($data); $i++){
				$tm=$base;
				$tm=$this->renderView($tm, "{{BASICO:IDENTIFICADOR}}", $data[$i][0]);
				$tm=$this->renderView($tm, "{{BASICO:AMIGO}}", $data[$i][1]);
				$tm=$this->renderView($tm, "{{BASICO:FECHA}}", $data[$i][2]);
				$tm=$this->renderView($tm, "{{BASICO:TEMA}}", $data[$i][3]);
				$tm=$this->renderView($tm, "{{BASICO:MATERIA}}", $data[$i][4]);

				$aux .= $tm;
			}

			$content=$this->renderView($content, "{{CICLO:NOTIFICACION_ASESORIA}}", $aux);
			$aux=$this->getTemplate("Core/View/assets/modal_calificacion.html");
			$content=$this->renderView($content, "{{COMPUESTO:MODAL_ASESORIA}}", $aux);

			return $content;
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


		public function rateAdvice($idAsesoria, $calificacion, $comentario){
			$studentModel=new studentDB();
			$studentModel->qualifyAsesoria($_SESSION["codigo"],$idAsesoria,count($calificacion), $comentario);
			$this->index();
		}

		public function rateCourse(){

		}
	}
?>