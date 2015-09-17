<?php

	require_once "Core/Controller/controller.php";
	//include_once "Core/Modelo/StudentBD.php";
	include_once "Core/Model/userDB.php";

	class Student extends Controller{

		public function index(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/inicio_estudiante.html");
			$menu=$this->getTemplate("Core/View/assets/menu_estudiante.html");
			//temporal
			$amigos=$this->getTemplate("Core/View/assets/estatico_tmp_amigosHora.html");
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA2}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA3}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA4}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA5}}",$amigos);
			$content=$this->renderView($content, "{{CICLO:AMIGOS_HORA6}}",$amigos);
			$amigos=$this->getTemplate("Core/View/assets/estatico_tmp_notificaciones.html");
			$content=$this->renderView($content, "{{CICLO:NOTIFICACION_ASESORIA}}",$amigos);
			$amigos=$this->getTemplate("Core/View/assets/modal_calificacion.html");
			$content=$this->renderView($content, "{{COMPUESTO:MODAL_ASESORIA}}",$amigos);
			//
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}

		public function topics(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/estudiante_ver_temas.html");
			$menu=$this->getTemplate("Core/View/assets/menu_estudiante.html");
			
			//cambiar
			$content=$this->renderView($content, "{{CICLO:TEMAS}}", "");
			//

			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}

		public function courses(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/estudiante_vista_cursos.html");
			$menu=$this->getTemplate("Core/View/assets/menu_estudiante.html");
			$courses=$this->getCourses();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}", $courses);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($index);
		}
		
		public function getCourses(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos_estudiante.html");
			$userModel=new UserDB();
			$data=$userModel->getCourses();

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
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$menu=$this->getTemplate("Core/View/assets/menu_estudiante.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}

		public function help(){
			$view=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$menu=$this->getTemplate("Core/View/assets/menu_estudiante.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$view=$this->renderView($view, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			$this->showView($view);
		}


		public function rateAdvice(){

		}

		public function rateCourse(){

		}
	}
?>