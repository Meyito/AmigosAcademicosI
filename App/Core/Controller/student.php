<?php

	require_once "Core/Controller/controller.php";
	//include_once "Core/Modelo/StudentBD.php";
	include_once "Core/Model/userDB.php";

	class Student extends Controller{

		public function index(){
			$index=$this->base("Core/View/assets/menu_estudiante.html");
			$this->indexP($index);
		}

		public function topics(){
			$index=$this->base("Core/View/assets/menu_estudiante.html");
			$content=$this->getTemplate("Core/View/contenedores/estudiante_ver_temas.html");
			
			//cambiar
			$content=$this->renderView($content, "{{CICLO:TEMAS}}", "");
			//

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
				$aux=$this->renderView($aux, "{{BASICO:FECHA_CURSO}}", $data[$i][4]);
				$aux=$this->renderView($aux, "{{id}}", $data[$i][0]);
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