<?php

	require_once "Core/Controller/controller.php";
	//include_once "Core/Modelo/AmigoBD.php";
	include_once "Core/Model/userDB.php";

	class Amigo extends Controller{

		public function index(){
			$index=$this->base("Core/View/assets/menu_amigo.html");
			$this->indexP($index);
		}

		public function changeAvatar(){
			$view=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function help(){
			$view=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/proximamente.html");
			$view=$this->renderView($view, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($view);
		}

		public function adviceRegister(){
			$index=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_asesoria.html");
			$content=$this->listarMaterias($content, -1);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$aux=$this->getTemplate("Static/js/ninjaScripts/AjaxTemas-Cursos.js");
			$index=$this->renderView($index, "{{COMPUESTO:LIBRERIAS_JS}}", $aux);
			$this->showView($index);
		}

		public function courseAssistantR(){
			$index=$this->base("Core/View/assets/menu_amigo.html");
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_lista_curso.html");
			$courses=$this->getCursos3();
			$content=$this->renderView($content, "{{CICLO:CURSOS}}", $courses);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$this->showView($index);
		}

		public function getCursos3(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos_asistencia.html");
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

		public function getCursos2(){
			$template=$this->getTemplate("Core/View/assets/lista_cursos.html");
			$userModel=new UserDB();
			$data=$userModel->getCursos();

			$aux="";
			$list="";
			for($i=0; $i<count($data); $i++){
				$aux=$template;
				$aux=$this->renderView($aux, "{{BASICO:AMIGO}}", "Denis Gonzales");
				$aux=$this->renderView($aux, "{{BASICO:TEMA}}", $data[$i][1]);
				$aux=$this->renderView($aux, "{{BASICO:FECHA}}", $data[$i][4]);
				$aux=$this->renderView($aux, "{{id}}", $data[$i][0]);
				$list=$list.$aux;
			}
			return $list;
		}

		public function registrarAsesoria(){
			echo "Registro asesoria";
		}

		public function registrarAsisC($id){
			$index=$this->base("Core/View/assets/menu_amigo.html");

			$adminModel=new AdminDB();
			$data=$adminModel->getCurso($id);
			$content=$this->getTemplate("Core/View/contenedores/registrar_asistencia_curso.html");
			$content=$this->renderView($content, "{{NOMBRE_CURSO}}", $data[0][1]);
			$index=$this->renderView($index, "{{COMPUESTO:CONTENIDO}}", $content);
			$index=$this->renderView($index, "{{COMPUESTO:LIBRERIAS_JS}}", "document.getElementById('tipoComentario1').addEventListener('click', cambiarTipoComentario, false);
      document.getElementById('tipoComentario2').addEventListener('click', cambiarTipoComentario, false);
      document.getElementById('0').addEventListener('keyup', copiarTextArea, false);");
			$this->showView($index);
		}
	}
?>