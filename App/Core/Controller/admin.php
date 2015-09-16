<?php

	require_once "Core/Controller/controller.php";
	//include_once "Core/Modelo/AdministradorBD.php";

	class Admin extends Controller{

		public function index(){
			$index=$this->base();
			$content=$this->getTemplate("Core/View/contenedores/inicio_amigo_academico.html");
			$menu=$this->getTemplate("Core/View/assets/menu_admin.html");
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{CICLO:ITEM_SIDEBAR}}", $menu);
			//gethorario, get cursos, get temas para renderizar la vista.
			$this->showView($index);
		}

		public function topicRegister(){

		}

		public function aaRegister(){

		}

		public function aaUpdate(){

		}

		public function createCourse(){

		}

		public function updateCourse(){
			
		}
	}
?>